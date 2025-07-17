<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Events\UserOnline;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class ChatController extends Controller
{
    // Lấy lịch sử chat, trả về kèm user
    public function index()
    {
        $messages = Message::with('user')->orderBy('id')->get();
        return response()->json([
            'messages' => $messages
        ]);
    }

    // Gửi tin nhắn, lưu userId, message, broadcast event
    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $msg = Message::create([
            'userId' => $user->id,
            'message' => $request->message
        ]);
        // Broadcast event UserOnline (chuẩn BE FE)
        broadcast(new \App\Events\UserOnline($user, $request->message))->toOthers();
        return response()->json($msg);
    }
}
