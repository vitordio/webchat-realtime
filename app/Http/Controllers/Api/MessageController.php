<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function listMessages(User $user)
    {
        $allUserMessages = $user->messages();
        return response()->json([
            'messages' => $allUserMessages
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = Message::create([
            'from' => Auth::user()->id,
            'to' => $request->to,
            'content' => filter_var($request->message, FILTER_SANITIZE_STRIPPED)
        ]);

        return back();
    }
}
