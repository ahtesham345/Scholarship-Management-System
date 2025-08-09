<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DisbursementService;

class DisbursementController extends Controller
{
    protected $service;

    public function __construct(DisbursementService $service)
    {
        $this->service = $service;
    }

    // Student: GET /awards/{awardId}/disbursements
    public function awardDisbursements($awardId)
    {
        return response()->json($this->service->getSchedulesForAward($awardId));
    }

    // Student: POST /disbursements/{id}/receipts
    public function uploadReceipt(Request $request, $id)
    {
        $request->validate(['file' => 'required|file']);
        return response()->json($this->service->uploadReceipt($id, $request->file('file')), 201);
    }

    // Student: GET /disbursements/{id}
    public function show($id)
    {
        return response()->json($this->service->showDisbursement($id));
    }

    // Admin: POST /admin/awards/{awardId}/schedules
    public function createSchedule(Request $request, $awardId)
    {
        $data = $request->validate([
            'schedules' => 'required|array',
            'schedules.*.cost_category_id' => 'required|exists:cost_categories,id',
            'schedules.*.scheduled_amount' => 'required|numeric',
            'schedules.*.scheduled_date' => 'required|date'
        ]);

        return response()->json(
            $this->service->createSchedule($awardId, $data['schedules'])
        );
    }

    // Admin: POST /admin/disbursements/{id}/pay
    public function pay(Request $request, $id)
    {
        $data = $request->validate([
            'paid_amount' => 'required|numeric',
            'paid_date' => 'required|date',
            'idempotency_key' => 'required|string|unique:disbursements,idempotency_key'
        ]);

        return response()->json(
            $this->service->pay($id, $data['paid_amount'], $data['paid_date'], $data['idempotency_key']),
            201
        );
    }

    // Admin: GET /admin/disbursements
    public function filter(Request $request)
    {
        return response()->json(
            $this->service->filter($request->only(['status', 'date', 'category_id']))
        );
    }

    // Admin: POST /admin/receipts/{id}/verify
    public function verifyReceipt(Request $request, $id)
    {
        $data = $request->validate(['status' => 'required|in:verified,rejected']);
        return response()->json($this->service->verifyReceipt($id, $data['status']));
    }
}
