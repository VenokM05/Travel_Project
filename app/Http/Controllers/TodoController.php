<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Itinerary;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->todos();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Sort
        $sortBy = $request->get('sort', 'due_date');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);
        
        $todos = $query->paginate(20);
        $itineraries = auth()->user()->itineraries()->get();
        
        // Stats
        $stats = [
            'total' => auth()->user()->todos()->count(),
            'pending' => auth()->user()->todos()->where('status', 'pending')->count(),
            'in_progress' => auth()->user()->todos()->where('status', 'in_progress')->count(),
            'completed' => auth()->user()->todos()->where('status', 'completed')->count(),
            'urgent' => auth()->user()->todos()->where('priority', 'urgent')->where('status', '!=', 'completed')->count(),
        ];
        
        return view('todos.index', compact('todos', 'itineraries', 'stats'));
    }

    public function create()
    {
        $itineraries = auth()->user()->itineraries()->get();
        return view('todos.create', compact('itineraries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'category' => 'nullable|string|max:255',
            'itinerary_id' => 'nullable|exists:itineraries,id',
        ]);

        $validated['user_id'] = auth()->id();

        Todo::create($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Task created successfully!');
    }

    public function show(Todo $todo)
    {
        $this->authorize('view', $todo);
        return view('todos.show', compact('todo'));
    }

    public function edit(Todo $todo)
    {
        $this->authorize('update', $todo);
        $itineraries = auth()->user()->itineraries()->get();
        return view('todos.edit', compact('todo', 'itineraries'));
    }

    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'category' => 'nullable|string|max:255',
            'itinerary_id' => 'nullable|exists:itineraries,id',
        ]);

        $todo->update($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);
        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', 'Task deleted successfully!');
    }

    public function toggleStatus(Todo $todo)
    {
        $this->authorize('update', $todo);
        
        if ($todo->status === 'completed') {
            $todo->update(['status' => 'pending']);
        } else {
            $todo->update(['status' => 'completed']);
        }

        return redirect()->back()
            ->with('success', 'Task status updated!');
    }
}
