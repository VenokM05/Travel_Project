<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItineraryRequest;
use App\Http\Requests\UpdateItineraryRequest;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ItineraryController extends Controller
{
    public function index(): View
    {
        // Eager load days and budgets to prevent N+1
        $itineraries = auth()->user()->itineraries()
            ->with(['days', 'budgets'])
            ->latest()
            ->paginate(12);
        
        return view('itineraries.index', compact('itineraries'));
    }

    public function create(): View
    {
        return view('itineraries.create');
    }

    public function store(StoreItineraryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();
        $validated['budget_total'] = $validated['budget_total'] ?? 0;

        Itinerary::create($validated);

        return redirect()->route('itineraries.index')
            ->with('success', 'Itinerary created successfully!');
    }

    public function show(Itinerary $itinerary): View
    {
        $this->authorize('view', $itinerary);
        
        $itinerary->load(['days', 'budgets', 'memories']);
        
        return view('itineraries.show', compact('itinerary'));
    }

    public function edit(Itinerary $itinerary): View
    {
        $this->authorize('update', $itinerary);
        
        return view('itineraries.edit', compact('itinerary'));
    }

    public function update(UpdateItineraryRequest $request, Itinerary $itinerary): RedirectResponse
    {
        $this->authorize('update', $itinerary);
        
        $validated = $request->validated();

        $itinerary->update($validated);

        return redirect()->route('itineraries.index')
            ->with('success', 'Itinerary updated successfully!');
    }

    public function destroy(Itinerary $itinerary): RedirectResponse
    {
        $this->authorize('delete', $itinerary);
        
        $itinerary->delete();

        return redirect()->route('itineraries.index')
            ->with('success', 'Itinerary deleted successfully!');
    }
}
