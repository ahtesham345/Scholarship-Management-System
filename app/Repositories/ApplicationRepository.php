<?php

namespace App\Repositories;

use App\Models\Application;
use App\Models\Document;
use App\Models\ReviewLog;

class ApplicationRepository
{
    public function create(array $data)
    {
        return Application::create($data);
    }

    public function findByIdForUser($id, $userId)
    {
        return Application::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function addDocument($applicationId, $filePath, $fileType)
    {
        return Document::create([
            'application_id' => $applicationId,
            'file_path' => $filePath,
            'file_type' => $fileType
        ]);
    }

    public function getUserApplications($userId)
    {
        return Application::where('user_id', $userId)->get();
    }

    public function findByIdWithDocuments($id)
    {
        return Application::with('documents')->findOrFail($id);
    }

    public function getLogs($applicationId)
    {
        return ReviewLog::where('application_id', $applicationId)->get();
    }

    public function getAllWithStudentAndScholarship()
    {
        return Application::with('student', 'scholarship')->get();
    }

    public function findByIdWithDocumentsAndStudent($id)
    {
        return Application::with('documents', 'student')->findOrFail($id);
    }

    public function updateStatus($applicationId, $status)
    {
        $application = Application::findOrFail($applicationId);
        $application->update(['status' => $status]);
        return $application;
    }

    public function createLog($applicationId, $adminId, $action, $comments = null)
    {
        return ReviewLog::create([
            'application_id' => $applicationId,
            'admin_id' => $adminId,
            'action' => $action,
            'comments' => $comments
        ]);
    }
}
