<?php

namespace App\Services;

use App\Repositories\DisbursementRepository;

class DisbursementService
{
    protected $repo;

    public function __construct(DisbursementRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getSchedulesForAward($awardId)
    {
        return $this->repo->getSchedulesByAward($awardId);
    }

    public function uploadReceipt($disbursementId, $file)
    {
        $path = $file->store('receipts', 'public');

        return $this->repo->createReceipt([
            'disbursement_id' => $disbursementId,
            'file_path'       => $path,
            'status'          => 'pending'
        ]);
    }

    public function showDisbursement($id)
    {
        return $this->repo->findDisbursementById($id);
    }

    public function createSchedule($awardId, array $schedules)
    {
        return $this->repo->createSchedules($awardId, $schedules);
    }

    public function pay($scheduleId, $paidAmount, $paidDate, $idempotencyKey)
    {
        // Idempotency check
        if ($existing = $this->repo->findByIdempotencyKey($idempotencyKey)) {
            return $existing;
        }

        return $this->repo->createDisbursement([
            'disbursement_schedule_id' => $scheduleId,
            'paid_amount'              => $paidAmount,
            'paid_date'                => $paidDate,
            'idempotency_key'          => $idempotencyKey
        ]);
    }

    public function filter(array $filters = [])
    {
        return $this->repo->filterDisbursements($filters);
    }

    public function verifyReceipt($receiptId, $status)
    {
        return $this->repo->updateReceiptStatus($receiptId, $status);
    }
}
