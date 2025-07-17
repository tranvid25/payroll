<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Events\UserOnline;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
{
    $message = Message::create([
        'from_id' => auth()->id(),
        'to_id' => $request->to_id,
        'text' => $request->text,
    ]);

    broadcast(new MessageSent($message, auth()->user()))->toOthers();

    return response()->json(['status' => 'sent']);
}
}
