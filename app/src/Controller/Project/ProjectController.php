<?php

namespace App\Controller\Project;

use App\Entity\Project\Project;
use App\Entity\Users\User;
use App\Forms\Projects\ProjectType;
use App\Services\Documents\DocumentService;
use App\Services\Documents\DocumentUploader;
use App\Services\ProjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/project', name: 'project_')]
class ProjectController extends AbstractController
{
    public function __construct(
        private ProjectService $projectService,
        private DocumentUploader $documentUploader,
        private DocumentService $documentService
    ) {
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $projects = $this->projectService->getProjectsByUser($user);

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/{id}', name: 'view', requirements: ['id' => Requirement::DIGITS])]
    public function view(Project $project): Response
    {
        return $this->render('project/view.html.twig', [
            'project' => $project
        ]);
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

            $project = $this->projectService->createProject($data['name'], $user);

            $uploadedDocument = $this->documentUploader->upload(
                $createProjectForm
                    ->get('document')
                    ->getData()
            );

            $this->documentService->saveDocument(
                $uploadedDocument,
                $project,
                $data['sourceLanguage'],
                $data['targetLanguage']
            );

            $this->addFlash('success', 'Project created successfully');

            return $this->redirectToRoute('home');
        }

        return $this->render('project/create.html.twig', [
            'form' => $createProjectForm,
        ]);
    }
}
