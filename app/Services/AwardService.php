<?php

namespace App\Services;

use App\Repositories\AwardRepository;

class AwardService
{
    protected $repo;

    public function __construct(AwardRepository $repo)
    {
        $this->repo = $repo;
    }

    public function storeCategory(array $data)
    {
        return $this->repo->createCategory($data);
    }

    public function listCategories()
    {
        return $this->repo->getAllCategories();
    }

    public function setBudgets($scholarshipId, array $budgets)
    {
        return $this->repo->createBudgets($scholarshipId, $budgets);
    }

    public function viewBudgets($scholarshipId)
    {
        return $this->repo->getBudgetsByScholarship($scholarshipId);
    }

    public function createAward($applicationId, $totalAmount, array $allocations)
    {
        $award = $this->repo->createAward([
            'application_id' => $applicationId,
            'total_amount' => $totalAmount
        ]);

        foreach ($allocations as $alloc) {
            $this->repo->createAllocation([
                'application_award_id' => $award->id,
                'cost_category_id' => $alloc['cost_category_id'],
                'committed_amount' => $alloc['committed_amount']
            ]);
        }

        return ['message' => 'Award created', 'award' => $award];
    }

    public function scholarshipReport($id)
    {
        return ['report' => 'Scholarship level report for ID ' . $id];
    }

    public function awardReport($awardId)
    {
        return ['report' => 'Award level report for ID ' . $awardId];
    }

    public function getStudentAwards($userId)
    {
        return $this->repo->getAwardsForStudent($userId);
    }
}
