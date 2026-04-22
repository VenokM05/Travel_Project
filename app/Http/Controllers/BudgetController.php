<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Budget;
use App\Models\Itinerary;
use App\Models\User;
use App\Services\BudgetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    public function __construct(protected BudgetService $budgetService)
    {
    }
    public function index(Request $request)
    {
        $query = auth()->user()->budgets()->with(['itinerary', 'expenses']);
        
        // Filter by itinerary
        if ($request->filled('itinerary_id')) {
            $query->where('itinerary_id', $request->itinerary_id);
        }
        
        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        $budgets = $query->latest()->paginate(12);
        $itineraries = auth()->user()->itineraries()->get();
        
        // Overall stats
        $stats = [
            'total_budgets' => auth()->user()->budgets()->count(),
            'total_allocated' => auth()->user()->budgets()->sum('total_budget'),
            'total_spent' => auth()->user()->budgets()->sum('total_spent'),
            'total_remaining' => auth()->user()->budgets()->sum('total_budget') - auth()->user()->budgets()->sum('total_spent'),
        ];
        
        return view('budgets.index', compact('budgets', 'itineraries', 'stats'));
    }

    public function create()
    {
        $itineraries = auth()->user()->itineraries()->get();
        $users = User::all(); // For group splits
        return view('budgets.create', compact('itineraries', 'users'));
    }

    public function store(StoreBudgetRequest $request)
    {
        $budget = $this->budgetService->createBudget(
            $request->validated(),
            auth()->user()
        );

        return redirect()->route('budgets.show', $budget)
            ->with('success', 'Budget created successfully!');
    }

    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);
        
        $budget->load(['expenses', 'splits.user', 'itinerary']);
        
        // Calculate statistics using service
        $stats = $this->budgetService->calculateStats($budget);
        
        // Expenses by category
        $expensesByCategory = $this->budgetService->getExpensesByCategory($budget);
        
        return view('budgets.show', compact('budget', 'stats', 'expensesByCategory'));
    }

    public function edit(Budget $budget)
    {
        $this->authorize('update', $budget);
        $itineraries = auth()->user()->itineraries()->get();
        return view('budgets.edit', compact('budget', 'itineraries'));
    }

    public function update(UpdateBudgetRequest $request, Budget $budget)
    {
        $this->authorize('update', $budget);
        
        $validated = $request->validated();

        $budget->update($validated);

        return redirect()->route('budgets.show', $budget)
            ->with('success', 'Budget updated successfully!');
    }

    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);
        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully!');
    }

    // Add expense
    public function addExpense(StoreExpenseRequest $request, Budget $budget)
    {
        $this->authorize('update', $budget);
        
        $this->budgetService->addExpense($budget, $request->validated());

        return redirect()->route('budgets.show', $budget)
            ->with('success', 'Expense added successfully!');
    }

    // Delete expense
    public function deleteExpense(Budget $budget, $expenseId)
    {
        $this->authorize('update', $budget);
        
        $expense = $budget->expenses()->findOrFail($expenseId);
        
        $this->budgetService->deleteExpense($budget, $expense);

        return redirect()->route('budgets.show', $budget)
            ->with('success', 'Expense deleted successfully!');
    }
}
