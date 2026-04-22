<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Budget;
use App\Models\BudgetSplit;
use App\Models\Itinerary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
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
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();
        $validated['total_spent'] = 0;
        $validated['status'] = 'active';

        DB::beginTransaction();
        try {
            $budget = Budget::create($validated);

            // Create splits for group budget
            if ($validated['type'] === 'group' && $request->filled('split_users')) {
                $splitUsers = is_array($request->split_users) ? $request->split_users : json_decode($request->split_users, true);
                $splitAmount = $validated['total_budget'] / count($splitUsers);
                
                foreach ($splitUsers as $userId) {
                    BudgetSplit::create([
                        'budget_id' => $budget->id,
                        'user_id' => $userId,
                        'share_percentage' => 100 / count($splitUsers),
                        'share_amount' => $splitAmount,
                        'paid_amount' => 0,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('budgets.show', $budget)
                ->with('success', 'Budget created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create budget. Please try again.']);
        }
    }

    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);
        
        $budget->load(['expenses', 'splits.user', 'itinerary']);
        
        // Calculate statistics
        $stats = [
            'total_budget' => $budget->total_budget,
            'total_spent' => $budget->total_spent,
            'remaining' => $budget->total_budget - $budget->total_spent,
            'percentage_used' => $budget->total_budget > 0 ? ($budget->total_spent / $budget->total_budget) * 100 : 0,
            'expense_count' => $budget->expenses()->count(),
        ];
        
        // Expenses by category
        $expensesByCategory = $budget->expenses()
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();
        
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
        
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Handle receipt upload
            $receiptPath = null;
            if ($request->hasFile('receipt')) {
                $receiptPath = $request->file('receipt')->store('receipts', 'public');
            }

            $validated['budget_id'] = $budget->id;
            $validated['expense_date'] = $validated['expense_date'] ?? now();
            $validated['receipt'] = $receiptPath;

            $expense = $budget->expenses()->create($validated);

            // Update budget total spent
            $budget->increment('total_spent', $validated['amount']);

            DB::commit();

            return redirect()->route('budgets.show', $budget)
                ->with('success', 'Expense added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to add expense. Please try again.']);
        }
    }

    // Delete expense
    public function deleteExpense(Budget $budget, $expenseId)
    {
        $this->authorize('update', $budget);
        
        $expense = $budget->expenses()->findOrFail($expenseId);
        
        DB::beginTransaction();
        try {
            $budget->decrement('total_spent', $expense->amount);
            $expense->delete();
            
            DB::commit();

            return redirect()->route('budgets.show', $budget)
                ->with('success', 'Expense deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete expense. Please try again.']);
        }
    }
}
