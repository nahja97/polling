<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $message = Message::select('message_content')->get();
        return response()->json(
            [
                'status' => 'success',
                'data' => $message
            ],200);
    }

    public function create(Request $req)
    {
        $data = $req->except('_token','method');
        $message = new Message();

        if($message->create($data)){
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Successfully Created Data Message'
                ],200);
        }
        return response()->json(
            [
                'status' => 'failed',
                'message' => 'Unsuccessfully Created Data Message'
            ],200);

    }

    public function update(Request $req)
    {
        $data = $req->except('_token','method');
        // dd($data);
        $message = Message::first();

        if($message->update($data)){
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Successfully Created Data Message'
                ],200);
        }
        return response()->json(
            [
                'status' => 'failed',
                'message' => 'Unsuccessfully Created Data Message'
            ],200);

    }
}
