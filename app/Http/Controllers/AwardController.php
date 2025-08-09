<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AwardService;

class AwardController extends Controller
{
    protected $service;

    public function __construct(AwardService $service)
    {
        $this->service = $service;
    }

    // Student: GET /my-awards
    public function myAwards(Request $request)
    {
        return response()->json($this->service->getStudentAwards($request->user()->id));
    }

    // Admin: POST /admin/cost-categories
    public function storeCategory(Request $request)
    {
        $data = $request->validate(['name' => 'required|string']);
        return response()->json($this->service->storeCategory($data), 201);
    }

    // Admin: GET /admin/cost-categories
    public function listCategories()
    {
        return response()->json($this->service->listCategories());
    }

    // Admin: POST /admin/scholarships/{id}/budgets
    public function setBudgets(Request $request, $scholarshipId)
    {
        $data = $request->validate([
            'budgets' => 'required|array',
            'budgets.*.cost_category_id' => 'required|exists:cost_categories,id',
            'budgets.*.amount' => 'required|numeric'
        ]);
        return response()->json($this->service->setBudgets($scholarshipId, $data['budgets']));
    }

    // Admin: GET /admin/scholarships/{id}/budgets
    public function viewBudgets($scholarshipId)
    {
        return response()->json($this->service->viewBudgets($scholarshipId));
    }

    // Admin: POST /admin/applications/{id}/award
    public function createAward(Request $request, $applicationId)
    {
        $data = $request->validate([
            'total_amount' => 'required|numeric',
            'allocations' => 'required|array',
            'allocations.*.cost_category_id' => 'required|exists:cost_categories,id',
            'allocations.*.committed_amount' => 'required|numeric'
        ]);
        return response()->json(
            $this->service->createAward($applicationId, $data['total_amount'], $data['allocations'])
        );
    }

    // Admin: GET /admin/reports/scholarships/{id}
    public function scholarshipReport($id)
    {
        return response()->json($this->service->scholarshipReport($id));
    }

    // Admin: GET /admin/reports/awards/{awardId}
    public function awardReport($awardId)
    {
        return response()->json($this->service->awardReport($awardId));
    }
}
