<?php

namespace App\Services;

use App\Repositories\ApplicationRepository;

class ApplicationService
{
    protected $repo;

    public function __construct(ApplicationRepository $repo)
    {
        $this->repo = $repo;
    }

    public function apply($userId, $scholarshipId)
    {
        return $this->repo->create([
            'user_id' => $userId,
            'scholarship_id' => $scholarshipId,
            'status' => 'pending'
        ]);
    }

    public function uploadDocument($userId, $applicationId, $file)
    {
        $app = $this->repo->findByIdForUser($applicationId, $userId);

        $path = $file->store('documents', 'public');

        return $this->repo->addDocument(
            $app->id,
            $path,
            $file->getClientMimeType()
        );
    }

    public function listUserApplications($userId)
    {
        return $this->repo->getUserApplications($userId);
    }

    public function show($applicationId)
    {
        return $this->repo->findByIdWithDocuments($applicationId);
    }

    public function viewLogs($applicationId)
    {
        return $this->repo->getLogs($applicationId);
    }

    public function listAll()
    {
        return $this->repo->getAllWithStudentAndScholarship();
    }

    public function adminShow($applicationId)
    {
        return $this->repo->findByIdWithDocumentsAndStudent($applicationId);
    }

    public function review($applicationId, $adminId, $action, $comments = null)
    {
        $this->repo->updateStatus($applicationId, $action);
        return $this->repo->createLog($applicationId, $adminId, $action, $comments);
    }
}
