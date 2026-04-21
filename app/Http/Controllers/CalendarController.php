<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $itineraries = $user->itineraries()->select('id', 'title', 'start_date', 'end_date', 'destination')->get();
        $todos = $user->todos()->whereNotNull('due_date')->select('id', 'title', 'due_date', 'priority')->get();
        $budgets = $user->budgets()->select('id', 'name', 'created_at')->get();
        
        return view('calendar.index', compact('itineraries', 'todos', 'budgets'));
    }
}
