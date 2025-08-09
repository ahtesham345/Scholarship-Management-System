<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScholarshipService;

class ScholarshipController extends Controller
{
    protected $service;

    public function __construct(ScholarshipService $service)
    {
        $this->service = $service;
    }

    // Student: List active scholarships
    public function index()
    {
        return response()->json($this->service->listActive());
    }

    // Admin: Create scholarship
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'deadline'    => 'required|date'
        ]);

        return response()->json($this->service->store($data), 201);
    }

    // Admin: Update scholarship
    public function update(Request $request, $id)
    {
        $data = $request->only(['title', 'description', 'deadline']);
        return response()->json($this->service->update($id, $data));
    }

    // Admin: Delete scholarship
    public function destroy($id)
    {
        $this->service->destroy($id);
        return response()->json(['message' => 'Scholarship deleted']);
    }
}
