<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function plans()
    {
        return view('subscription.plans');
    }
}
