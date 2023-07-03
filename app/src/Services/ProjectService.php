<?php

namespace App\Services;

use App\Entity\Project\Project;
use App\Entity\Users\User;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\Collection;

class ProjectService
{
    public function __construct(private ProjectRepository $projectRepository)
    {
    }

    public function createProject(string $name, User $user): Project
    {
        $project = new Project();
        $project->setName($name);
        $project->setUser($user);

        $this->projectRepository->save($project);

        return $project;
    }

    public function getProjectsByUser(User $user): Collection
    {
        return $user->getProjects();
    }
}
