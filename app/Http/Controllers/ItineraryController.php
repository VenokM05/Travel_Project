<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItineraryRequest;
use App\Http\Requests\UpdateItineraryRequest;
use App\Models\Itinerary;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    public function index()
    {
        $itineraries = auth()->user()->itineraries()->latest()->paginate(12);
        return view('itineraries.index', compact('itineraries'));
    }

    public function create()
    {
        return view('itineraries.create');
    }

    public function store(StoreItineraryRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();
        $validated['budget_total'] = $validated['budget_total'] ?? 0;

        Itinerary::create($validated);

        return redirect()->route('itineraries.index')
            ->with('success', 'Itinerary created successfully!');
    }

    public function show(Itinerary $itinerary)
    {
        $this->authorize('view', $itinerary);
        
        $itinerary->load(['days', 'budgets', 'memories']);
        
        return view('itineraries.show', compact('itinerary'));
    }

    public function edit(Itinerary $itinerary)
    {
        $this->authorize('update', $itinerary);
        
        return view('itineraries.edit', compact('itinerary'));
    }

    public function update(UpdateItineraryRequest $request, Itinerary $itinerary)
    {
        $this->authorize('update', $itinerary);
        
        $validated = $request->validated();

        $itinerary->update($validated);

        return redirect()->route('itineraries.index')
            ->with('success', 'Itinerary updated successfully!');
    }

    public function destroy(Itinerary $itinerary)
    {
        $this->authorize('delete', $itinerary);
        
        $itinerary->delete();

        return redirect()->route('itineraries.index')
            ->with('success', 'Itinerary deleted successfully!');
    }
}
