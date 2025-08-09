<?php

namespace App\Repositories;

use App\Models\Disbursement;
use App\Models\DisbursementSchedule;
use App\Models\Receipt;

class DisbursementRepository
{
    public function getSchedulesByAward($awardId)
    {
        return DisbursementSchedule::with('disbursements')
            ->where('application_award_id', $awardId)
            ->get();
    }

    public function createReceipt(array $data)
    {
        return Receipt::create($data);
    }

    public function findDisbursementById($id)
    {
        return Disbursement::with('receipt')->findOrFail($id);
    }

    public function createSchedules($awardId, array $schedules)
    {
        $created = [];
        foreach ($schedules as $sch) {
            $created[] = DisbursementSchedule::create([
                'application_award_id' => $awardId,
                'cost_category_id'     => $sch['cost_category_id'],
                'scheduled_amount'     => $sch['scheduled_amount'],
                'scheduled_date'       => $sch['scheduled_date'],
            ]);
        }
        return collect($created);
    }

    public function createDisbursement(array $data)
    {
        return Disbursement::create($data);
    }

    public function filterDisbursements(array $filters = [])
    {
        $query = Disbursement::query();

        if (!empty($filters['status'])) {
            $query->whereHas('receipt', function($q) use ($filters) {
                $q->where('status', $filters['status']);
            });
        }

        if (!empty($filters['date'])) {
            $query->whereDate('paid_date', $filters['date']);
        }

        if (!empty($filters['category_id'])) {
            $query->whereHas('schedule', function($q) use ($filters) {
                $q->where('cost_category_id', $filters['category_id']);
            });
        }

        return $query->get();
    }

    public function updateReceiptStatus($id, $status)
    {
        $receipt = Receipt::findOrFail($id);
        $receipt->update(['status' => $status]);
        return $receipt;
    }

    public function findByIdempotencyKey($key)
    {
        return Disbursement::where('idempotency_key', $key)->first();
    }
}
