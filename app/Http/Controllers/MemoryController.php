<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use App\Models\Itinerary;
use Illuminate\Http\Request;

class MemoryController extends Controller
{
    public function index()
    {
        $memories = auth()->user()->memories()->latest()->paginate(12);
        return view('memories.index', compact('memories'));
    }

    public function create()
    {
        $itineraries = auth()->user()->itineraries()->orderBy('start_date', 'desc')->get();
        return view('memories.create', compact('itineraries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'date' => 'required|date',
            'media_urls' => 'nullable|string', // JSON string from hidden field
            'itinerary_id' => 'nullable|exists:itineraries,id',
            'mood' => 'nullable|string|max:50',
        ]);

        // Decode media_urls JSON string to array
        if ($validated['media_urls']) {
            $validated['media_urls'] = json_decode($validated['media_urls'], true);
        } else {
            $validated['media_urls'] = [];
        }

        $validated['user_id'] = auth()->id();

        Memory::create($validated);

        return redirect()->route('memories.index')
            ->with('success', 'Memory saved!');
    }

    public function show(Memory $memory)
    {
        $this->authorize('view', $memory);
        
        $memory->load(['user', 'itinerary']);
        
        return view('memories.show', compact('memory'));
    }

    public function edit(Memory $memory)
    {
        $this->authorize('update', $memory);
        
        $itineraries = auth()->user()->itineraries()->orderBy('start_date', 'desc')->get();
        
        return view('memories.edit', compact('memory', 'itineraries'));
    }

    public function update(Request $request, Memory $memory)
    {
        $this->authorize('update', $memory);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'date' => 'required|date',
            'media_urls' => 'nullable|array',
            'media_urls.*' => 'url',
            'itinerary_id' => 'nullable|exists:itineraries,id',
            'mood' => 'nullable|string|max:50',
        ]);

        $memory->update($validated);

        return redirect()->route('memories.index')
            ->with('success', 'Memory updated!');
    }

    public function destroy(Memory $memory)
    {
        $this->authorize('delete', $memory);
        
        $memory->delete();

        return redirect()->route('memories.index')
            ->with('success', 'Memory deleted!');
    }
}
