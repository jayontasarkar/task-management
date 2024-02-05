<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    protected $projectModel;

    public function __construct(Project $project)
    {
        $this->projectModel = $project;
    }

    /**
     * Get all projects for an user
     *
     * @param integer $userId
     * @return Collection<Project>
     */
    public function forUser($userId)
    {
        return $this->projectModel->where('user_id', $userId)->latest()->get();
    }

    /**
     * Find project by id
     *
     * @param [integer $project
     * @return Project
     */
    public function findOne($project)
    {
        return $this->projectModel->findOrFail($project);
    }

    /**
     * Create a new project
     *
     * @param array $data
     * @return Project
     */
    public function create($data)
    {
        return $this->projectModel->create($data);
    }

    /**
     * Delete a project by project id
     *
     * @param integer $projectId
     * @return Project
     */
    public function delete($projectId)
    {
        return $this->projectModel->findOrFail($projectId)->delete();
    }
}