<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Polling;

class PollingController extends Controller
{
    public function index()
    {
        $polling = Polling::select('id', 'name', 'description')->get();
        return response()->json(
            [
                'status' => 'success',
                'data' => $polling
            ],200);
    }

    public function create(Request $req)
    {
        $data = $req->except('_token','method');
        $polling = new Polling();

        if($polling->create($data)){
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Successfully Created Data Polling'
                ],200);
        }
        return response()->json(
            [
                'status' => 'failed',
                'message' => 'Unsuccessfully Created Data Polling'
            ],200);

    }
}
