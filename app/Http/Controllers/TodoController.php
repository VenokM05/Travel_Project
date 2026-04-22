<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TodoController extends Controller
{
    public function index(Request $request): View
    {
        $query = auth()->user()->todos()->with('itinerary'); // Eager load itinerary to prevent N+1
        
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

    public function create(): View
    {
        $itineraries = auth()->user()->itineraries()->get();
        return view('todos.create', compact('itineraries'));
    }

    public function store(StoreTodoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        Todo::create($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Task created successfully!');
    }

    public function show(Todo $todo): View
    {
        $this->authorize('view', $todo);
        return view('todos.show', compact('todo'));
    }

    public function edit(Todo $todo): View
    {
        $this->authorize('update', $todo);
        $itineraries = auth()->user()->itineraries()->get();
        return view('todos.edit', compact('todo', 'itineraries'));
    }

    public function update(UpdateTodoRequest $request, Todo $todo): RedirectResponse
    {
        $this->authorize('update', $todo);
        
        $validated = $request->validated();

        $todo->update($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Todo $todo): RedirectResponse
    {
        $this->authorize('delete', $todo);
        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', 'Task deleted successfully!');
    }

    public function toggleStatus(Todo $todo): RedirectResponse
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
