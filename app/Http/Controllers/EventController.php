<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{

    public function fetchEvents()
    {
        $events = Event::all()->map(function ($event) {
            // Convert the start and end fields to Carbon instances before calling toIso8601String()
            $start = Carbon::parse($event->start);
            $end = $event->end ? Carbon::parse($event->end) : null;
    
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $start->toIso8601String(), // Ensure proper format
                'end' => $end ? $end->toIso8601String() : null,
                'className' => $event->class_name ? [$event->class_name] : [],
                'allDay' => false,
            ];
        });
    
        return response()->json($events);
    }
    
    public function store(Request $request)
    {
        try {
            $start = Carbon::parse($request->input('start'))->toDateTimeString();
            $end = $request->has('end') ? Carbon::parse($request->input('end'))->toDateTimeString() : null;
    
            $event = Event::create([
                'title' => $request->input('title'),
                'start' => $start,
                'end' => $end,
                'class_name' => $request->input('class_name'),
            ]);
    
            return response()->json($event);
        } catch (\Exception $e) {
            Log::error('Event creation failed: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'error' => 'Failed to create event',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    

    public function destroy($id)
    {
        $event = Event::find($id);

        if ($event) {
            $event->delete();

            return response()->json(['message' => 'Event deleted successfully.'], 200);
        }

        return response()->json(['message' => 'Event not found.'], 404);
    }
}
