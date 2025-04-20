<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Call;
use Carbon\Carbon;
use PDO;

class HomeController extends Controller
{
    public function dashboard()
    {
        $totalContacts = User::count();
        $activeContacts = User::whereHas('contact', function ($q) {
            $q->where('is_active', true);
        })->count();
    
        $totalCalls = Call::count();
        $calls = Call::all();
        $answeredCalls = Call::where('status', 'answered')->count();
        $missedCalls = Call::where('status', 'missed')->count();
        $escalatedCalls = Call::where('status', 'escalated')->count();
    
        // Satisfactory call: duration >= 30 seconds
        $satisfactoryThreshold = 30;
    
        // Aggregate call performance by time period
        $performanceData = [
            'week' => $this->getCallPerformanceData('week', $satisfactoryThreshold),
            'month' => $this->getCallPerformanceData('month', $satisfactoryThreshold),
            'year' => $this->getCallPerformanceData('year', $satisfactoryThreshold),
            'all' => $this->getCallPerformanceData('all', $satisfactoryThreshold),
        ];
        $satisfactoryThreshold = 30;
        $satisfactoryCalls = Call::where('status', 'answered')
        ->whereNotNull('started_at')
        ->whereNotNull('ended_at')
        ->get()
        ->filter(function ($call) use ($satisfactoryThreshold) {
            $start = Carbon::parse($call->start_time);
            $end = Carbon::parse($call->end_time);
            return $end->diffInSeconds($start) >= $satisfactoryThreshold;
        })->count();
        $callPerformancePercent = $answeredCalls > 0 
        ? round(($satisfactoryCalls / $answeredCalls) * 100) 
        : 0;
        $data = [
            'totalCalls' => $totalCalls,
            'answeredCalls' => $answeredCalls,
            'answeredPercent' => $totalCalls > 0 ? round(($answeredCalls / $totalCalls) * 100) : 0,
            'missedCalls' => $missedCalls,
            'escalatedCalls' => $escalatedCalls,
            'totalContacts' => $totalContacts,
            'activeContacts' => $activeContacts,
            'activePercent' => $totalContacts > 0 ? round(($activeContacts / $totalContacts) * 100) : 0,
            'performanceChartData' => $performanceData,
            'callPerformance'      => $callPerformancePercent,
            'calls' => $calls,
        ];
    
        return view('welcome', $data);
    }

    public function home(){
        $data['plans'] = Plan::all();
        return view('home', $data);
    }

    public function checkout(Request $request)
    {
        $plan = Plan::findOrFail($request->plan_id);
    
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $plan->name,
                    ],
                    'unit_amount' => $plan->price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('create.account') . '?plan_id=' . $plan->id,
            'cancel_url' => url('/'),
        ]);
    
        return redirect($session->url);
    }
    
    public function success()
    {
        return view('payment.success');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }

    public function createAccount(Request $request)
    {
        $plan_id = $request->query('plan_id');
        if (!$plan_id) {
            return redirect('/')->with('error', 'Please select a plan before registering.');
        }
    
        return view('frontend.register', compact('plan_id'));
    }

    public function chatIndex(){
        $data['users'] = User::where('owner_id', auth()->id())->get();
        return view('frontend.message.chat', $data);
    }


    private function getCallPerformanceData($range, $threshold)
    {
        $query = Call::selectRaw("
                DATE_FORMAT(created_at, ?) as label,
                COUNT(*) as total_calls,
                SUM(CASE WHEN status = 'answered' THEN 1 ELSE 0 END) as answered_calls,
                SUM(CASE WHEN status = 'answered' AND TIMESTAMPDIFF(SECOND, started_at, ended_at) >= ? THEN 1 ELSE 0 END) as satisfactory_calls
            ")
            ->groupBy('label');

        switch ($range) {
            case 'week':
                $format = '%a'; // Mon, Tue...
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
                break;
            case 'month':
                $format = '%d'; // day of month
                $query->where('created_at', '>=', Carbon::now()->subMonth());
                break;
            case 'year':
                $format = '%b'; // Jan, Feb...
                $query->where('created_at', '>=', Carbon::now()->subYear());
                break;
            default:
                $format = '%b'; // default: month
                break;
        }

        return $query->addBinding($format, 'select')
            ->addBinding($threshold, 'select')
            ->orderBy('label')
            ->get()
            ->map(function ($row) {
                return [
                    'label' => $row->label,
                    'performance' => $row->answered_calls > 0
                        ? round(($row->satisfactory_calls / $row->answered_calls) * 100)
                        : 0
                ];
            });
    }
    
    public function calender(){
        return view('admin.calender');
    }

    public function setting(){
        return view('admin.profile');
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[!@#$%^&*(),.?":{}|<>]/', 
                    'confirmed',
                ],
            ]);
    
            $user = auth()->user();
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            return redirect()->back()->with('success', 'Password updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update password. Please try again.');
        }
    }
    
}
