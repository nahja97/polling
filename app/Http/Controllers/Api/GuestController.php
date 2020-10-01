<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Guest;

class GuestController extends Controller
{
    public function index()
    {
        $guest = Guest::all();
        return response()->json(
            [
                'status' => 'success',
                'data' => $guest
            ],200);
    }

    public function create(Request $req)
    {
        $data = $req->except('_token','method');
        $data['remember_token'] = str_replace(' ', '-', $data['name']);
        $guest = new Guest();
        $check_guest = Guest::where('remember_token', $data['remember_token'])->latest('updated_at')->first();

        if($check_guest){
            $data['remember_token'] .= $check_guest->id;
        }
        if($guest->create($data)){
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Successfully Created Data Guest'
                ],200);
        }
        return response()->json(
            [
                'status' => 'failed',
                'message' => 'Unsuccessfully Created Data Guest'
            ],200);

    }
}
