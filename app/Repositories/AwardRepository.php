<?php

namespace App\Repositories;

use App\Models\CostCategory;
use App\Models\ScholarshipBudget;
use App\Models\ApplicationAward;
use App\Models\ApplicationAwardAllocation;

class AwardRepository
{
    public function createCategory(array $data)
    {
        return CostCategory::create($data);
    }

    public function getAllCategories()
    {
        return CostCategory::all();
    }

    public function createBudgets($scholarshipId, array $budgets)
    {
        $created = [];
        foreach ($budgets as $budget) {
            $created[] = ScholarshipBudget::create([
                'scholarship_id' => $scholarshipId,
                'cost_category_id' => $budget['cost_category_id'],
                'amount' => $budget['amount']
            ]);
        }
        return $created;
    }

    public function getBudgetsByScholarship($scholarshipId)
    {
        return ScholarshipBudget::with('costCategory')
            ->where('scholarship_id', $scholarshipId)
            ->get();
    }

    public function createAward(array $data)
    {
        return ApplicationAward::create($data);
    }

    public function createAllocation(array $data)
    {
        return ApplicationAwardAllocation::create($data);
    }

    public function getAwardsForStudent($userId)
    {
        return ApplicationAward::with('application.scholarship')
            ->whereHas('application', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->get();
    }
}
