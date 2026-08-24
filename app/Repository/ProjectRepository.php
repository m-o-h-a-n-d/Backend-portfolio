<?php

namespace App\Repository;

use App\Models\Project;

class ProjectRepository
{
    public function getProjects()
    {
        return Project::with(['teams', 'service'])->latest('created_at')->get();
    }

    public function getProject($id)
    {
        return Project::find($id);
    }

    public function store($data)
    {
        return Project::create($data);
    }

    public function update($project, $data)
    {
        return $project->update($data);
    }

    public function delete($project)
    {
        return $project->delete();
    }

    public function createProjectTeams($project, $teams)
    {
        return $project->teams()->sync($teams);
    }
}
