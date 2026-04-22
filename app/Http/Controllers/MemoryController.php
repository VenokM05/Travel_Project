<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemoryRequest;
use App\Http\Requests\UpdateMemoryRequest;
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

    public function store(StoreMemoryRequest $request)
    {
        $validated = $request->validated();

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

    public function update(UpdateMemoryRequest $request, Memory $memory)
    {
        $this->authorize('update', $memory);
        
        $validated = $request->validated();

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
