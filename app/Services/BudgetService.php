<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\BudgetSplit;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BudgetService
{
    /**
     * Create a new budget with optional group splits
     *
     * @param array $data Validated budget data
     * @param User $user The authenticated user
     * @return Budget
     */
    public function createBudget(array $data, User $user): Budget
    {
        return DB::transaction(function () use ($data, $user) {
            $budget = $user->budgets()->create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'total_budget' => $data['total_budget'],
                'currency' => $data['currency'],
                'type' => $data['type'],
                'itinerary_id' => $data['itinerary_id'] ?? null,
                'total_spent' => 0,
                'status' => 'active',
            ]);

            // Create splits for group budget
            if ($data['type'] === 'group' && !empty($data['split_users'])) {
                $this->createBudgetSplits($budget, $data['split_users']);
            }

            return $budget;
        });
    }

    /**
     * Add an expense to a budget
     *
     * @param Budget $budget The budget to add expense to
     * @param array $data Validated expense data
     * @return Expense
     */
    public function addExpense(Budget $budget, array $data): Expense
    {
        return DB::transaction(function () use ($budget, $data) {
            // Handle receipt upload
            $receiptPath = null;
            if (isset($data['receipt']) && $data['receipt'] instanceof \Illuminate\Http\UploadedFile) {
                $receiptPath = $data['receipt']->store('receipts', 'public');
            }

            $expense = $budget->expenses()->create([
                'title' => $data['title'],
                'amount' => $data['amount'],
                'category' => $data['category'],
                'description' => $data['description'] ?? null,
                'expense_date' => $data['expense_date'] ?? now(),
                'receipt' => $receiptPath,
            ]);

            // Update budget total spent
            $budget->increment('total_spent', $data['amount']);

            return $expense;
        });
    }

    /**
     * Delete an expense and update budget total
     *
     * @param Budget $budget The budget containing the expense
     * @param Expense $expense The expense to delete
     * @return void
     */
    public function deleteExpense(Budget $budget, Expense $expense): void
    {
        DB::transaction(function () use ($budget, $expense) {
            // Delete receipt file if exists
            if ($expense->receipt) {
                Storage::disk('public')->delete($expense->receipt);
            }

            // Decrement budget total spent
            $budget->decrement('total_spent', $expense->amount);

            // Delete the expense
            $expense->delete();
        });
    }

    /**
     * Create budget splits for group budgets
     *
     * @param Budget $budget The budget to create splits for
     * @param array $userIds Array of user IDs to split between
     * @return void
     */
    protected function createBudgetSplits(Budget $budget, array $userIds): void
    {
        $splitCount = count($userIds);
        $splitAmount = $budget->total_budget / $splitCount;
        $sharePercentage = 100 / $splitCount;

        foreach ($userIds as $userId) {
            BudgetSplit::create([
                'budget_id' => $budget->id,
                'user_id' => $userId,
                'share_percentage' => $sharePercentage,
                'share_amount' => $splitAmount,
                'paid_amount' => 0,
            ]);
        }
    }

    /**
     * Calculate budget statistics
     *
     * @param Budget $budget
     * @return array
     */
    public function calculateStats(Budget $budget): array
    {
        $totalBudget = $budget->total_budget;
        $totalSpent = $budget->total_spent;
        $remaining = $totalBudget - $totalSpent;
        $percentageUsed = $totalBudget > 0 ? ($totalSpent / $totalBudget) * 100 : 0;

        return [
            'total_budget' => $totalBudget,
            'total_spent' => $totalSpent,
            'remaining' => $remaining,
            'percentage_used' => round($percentageUsed, 2),
            'expense_count' => $budget->expenses()->count(),
        ];
    }

    /**
     * Get expenses grouped by category
     *
     * @param Budget $budget
     * @return \Illuminate\Support\Collection
     */
    public function getExpensesByCategory(Budget $budget)
    {
        return $budget->expenses()
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();
    }
}
