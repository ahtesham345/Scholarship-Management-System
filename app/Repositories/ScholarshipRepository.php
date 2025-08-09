<?php

namespace App\Repositories;

use App\Models\Scholarship;

class ScholarshipRepository
{
    public function getActiveScholarships()
    {
        return Scholarship::whereDate('deadline', '>=', now())->get();
    }

    public function create(array $data)
    {
        return Scholarship::create($data);
    }

    public function findById($id)
    {
        return Scholarship::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $scholarship = $this->findById($id);
        $scholarship->update($data);
        return $scholarship;
    }

    public function delete($id)
    {
        return $this->findById($id)->delete();
    }
}
