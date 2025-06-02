<?php

namespace App\Http\Controllers;

use App\Imports\ContactsImport;
use App\Models\Call;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = User::where('owner_id', auth()->id())
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Contact');
        })
        ->get();
        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        $data['countries'] = Country::with('cities')->get();
        return view('admin.contacts.add',$data);
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'gender' => 'required|in:Male,Female,Other',
        'birth' => 'required|date',
        'phone' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'country_id' => 'required|exists:countries,id',
        'city_id' => 'required|exists:cities,id',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    DB::beginTransaction();
    try {
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        } else {
            $photoPath = 'photos/user.jpg';
        }

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make('defaultpassword123'),
            'photo' => $photoPath,
            'owner_id' => auth()->user()->id,
        ]);

        $user->assignRole('Contact');

        Contact::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'specialty' => $validated['specialty'] ?? null,
            'gender' => $validated['gender'],
            'birth' => $validated['birth'],
            'phone' => $validated['phone'],
            'country_id' => $validated['country_id'],
            'city_id' => $validated['city_id'],
        ]);

        DB::commit();

        return redirect()->route('contacts.index')->with('success', 'Contact added');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Contact creation failed', [
            'message' => $e->getMessage(),
            'exception' => $e,
        ]);
        return back()->withInput()->withErrors(['error' => 'Something went wrong. Please try again.']);
    }
}


    public function edit($id)
    {
        $data['user'] = User::with('contact')->findOrFail($id);
        $data['countries'] = Country::with('cities')->get();
        return view('admin.contacts.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $contact = $user->contact;
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'nullable|in:Male,Female,Other',
            'birth' => 'nullable|date',
            'phone' => 'nullable|string',
            'email' => 'required|email|unique:users,email,' . $contact->user_id,
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        DB::beginTransaction();
    
        try {
    
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
                $user->photo = $photoPath;
            }
    
            $user->update([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
            ]);
    
            $contact->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'specialty' => $validated['specialty'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'birth' => $validated['birth'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'country' => $validated['country_id'],
                'city' => $validated['city_id'],
            ]);
    
            DB::commit();
    
            return redirect()->route('contacts.index')->with('success', 'Contact updated successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Contact update failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $contact = $user->contact;
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $contact->delete();
            $user->delete();
            DB::commit();
            
            return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Contact deletion failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }    

    public function updateStatus(Request $request,$id){
        $call = Call::findOrFail($id);
        $call->status = $request->status;
        $call->save();

        return response()->json(['success' => true]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'contacts_file' => 'required|file|mimes:xlsx,xls',
        ]);
    
        try {
            Excel::import(new ContactsImport, $request->file('contacts_file'));
            Log::info('Contacts import successful.');
            return redirect()->back()->with('success', 'Contacts imported successfully!');
        } catch (\Exception $e) {
            Log::error('Contacts import failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
    
            return redirect()->back()->with('error', 'There was an error importing contacts. Check logs for details.');
        }
    }
}
