<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMailController;
use Illuminate\Support\Facades\Mail;

class CallMailController extends Controller
{
    public function index()
    {
        Mail::to("nahjafalahilumam@gmail.com")->send(new SendMailController());
        return "Email telah dikirim";
    }
}
