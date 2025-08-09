<?php

namespace App\Services;

use App\Repositories\ScholarshipRepository;

class ScholarshipService
{
    protected $repo;

    public function __construct(ScholarshipRepository $repo)
    {
        $this->repo = $repo;
    }

    public function listActive()
    {
        return $this->repo->getActiveScholarships();
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->repo->delete($id);
    }
}
