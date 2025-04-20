<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Message;
use App\Models\Response;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('message');
        if (empty($userMessage)) {
            return response()->json(['error' => 'Message cannot be empty'], 400);
        }
    
        // Assuming you're passing the receiver_id with the request
        $receiverId = $request->input('userId');
         
        // Save user message to database
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'content' => $userMessage,
            'sender' => 'user',
        ]);
    
        // Fetch bot response
        $responseText = $this->generateResponse($userMessage);
    
        // Save bot response to database
        $responseMessage = Message::create([
            'sender_id' => $receiverId, // Bot is the "receiver" here
            'receiver_id' => Auth::id(),
            'content' => $responseText,
            'sender' => 'bot',
        ]);
    
        // Fetch chat history
        $chatHistory = Message::where(function($query) use ($receiverId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $receiverId);
        })
        ->orWhere(function($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get();
    
        return response()->json([
            'userMessage' => $userMessage,
            'botResponse' => $responseText,
            'timestamp' => now()->format('h:i A'),
            'chatHistory' => $chatHistory,
        ]);
    }
    
    

    public function generateResponse($userMessage)
    {
        // Search for a predefined response based on the user's message
        $response = Response::where('keyword', 'like', '%' . $userMessage . '%')->first();
    
        if ($response) {
            return $response->response;
        }
    
        return "I'm sorry, I don't understand that.";
    }

    public function fetchChatHistory($userId)
    {
        $user = User::find($userId);
        $chatHistory = Message::where(function($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $userId);
        })
        ->orWhere(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', auth()->id());
        })
        ->orderBy('created_at', 'asc')
        ->get();
    
        return response()->json([
            'chatHistory' => $chatHistory,
            'receiverPhoto' => $user->photo,
        ]);
    }

    public function initiateCall(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'type' => 'required|in:voice,video',
        ]);

        $call = Call::create([
            'caller_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'type' => $request->type,
            'started_at' => Carbon::now(),
            'status' => 'initiated',
        ]);

        // Optional: return call info to frontend
        return response()->json(['call' => $call], 201);
        
    }

    public function endCall(Request $request)
    {
        $request->validate([
            'call_id' => 'required|exists:calls,id',
        ]);

        $call = Call::find($request->call_id);
        $call->ended_at = Carbon::now();
        $call->save();

        return response()->json(['message' => 'Call ended.']);
    }

    public function tagCall(Request $request)
    {
        $call = Call::find($request->call_id);
        if ($call) {
            $call->status = $request->status;
            $call->save();
            return response()->json(['message' => 'Tagged']);
        }
        return response()->json(['error' => 'Call not found'], 404);
        
    }

}
