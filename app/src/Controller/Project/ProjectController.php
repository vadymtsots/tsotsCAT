<?php

namespace App\Controller\Project;

use App\Entity\Project\Project;
use App\Entity\Users\User;
use App\Forms\Projects\ProjectType;
use App\Services\ProjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project', name: 'project_')]
class ProjectController extends AbstractController
{
    public function __construct(private ProjectService $projectService)
    {
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $createProjectForm = $this->createForm(ProjectType::class);

        $createProjectForm->handleRequest($request);

        if ($createProjectForm->isSubmitted() && $createProjectForm->isValid()) {
            $data = $createProjectForm->getData();

            /** @var User $user */
            $user = $this->getUser();

            $this->projectService->createProject($data, $user);

            return $this->redirectToRoute('home');
        }

        return $this->render('project/create.html.twig', [
            'form' => $createProjectForm,
        ]);
    }
}
