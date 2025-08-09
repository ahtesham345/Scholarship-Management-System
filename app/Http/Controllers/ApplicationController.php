<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApplicationService;

class ApplicationController extends Controller
{
    protected $service;

    public function __construct(ApplicationService $service)
    {
        $this->service = $service;
    }

    // Student: Apply to scholarship
    public function store(Request $request)
    {
        $data = $request->validate([
            'scholarship_id' => 'required|exists:scholarships,id'
        ]);

        return response()->json(
            $this->service->apply($request->user()->id, $data['scholarship_id']),
            201
        );
    }

    // Student: Upload documents
    public function uploadDocument(Request $request, $id)
    {
        $request->validate(['file' => 'required|file']);

        return response()->json(
            $this->service->uploadDocument($request->user()->id, $id, $request->file('file')),
            201
        );
    }

    // Student: View own applications
    public function myApplications(Request $request)
    {
        return response()->json($this->service->listUserApplications($request->user()->id));
    }

    // Student: View application details
    public function show($id)
    {
        return response()->json($this->service->show($id));
    }

    // Student: View review logs
    public function logs($id)
    {
        return response()->json($this->service->viewLogs($id));
    }

    // Admin: List all applications
    public function allApplications()
    {
        return response()->json($this->service->listAll());
    }

    // Admin: View specific application
    public function adminShow($id)
    {
        return response()->json($this->service->adminShow($id));
    }

    // Admin: Approve or reject
    public function review(Request $request, $id)
    {
        $data = $request->validate([
            'action' => 'required|in:approved,rejected',
            'comments' => 'nullable|string'
        ]);

        return response()->json(
            $this->service->review($id, $request->user()->id, $data['action'], $data['comments'])
        );
    }
}
