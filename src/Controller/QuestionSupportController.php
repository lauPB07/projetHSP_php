<?php

namespace App\Controller;

use App\Entity\QuestionSupport;
use App\Entity\ReponseSupport;
use App\Form\QuestionSupportType;
use App\Repository\QuestionSupportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/question/support')]
final class QuestionSupportController extends AbstractController
{
    #[Route(name: 'app_question_support_index', methods: ['GET'])]
    public function index(QuestionSupportRepository $questionSupportRepository): Response
    {
        return $this->render('question_support/index.html.twig', [
            'question_supports' => $questionSupportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_question_support_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $questionSupport = new QuestionSupport();
        $form = $this->createForm(QuestionSupportType::class, $questionSupport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($questionSupport);
            $entityManager->flush();

            return $this->redirectToRoute('app_question_support_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('question_support/new.html.twig', [
            'question_support' => $questionSupport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_question_support_show', methods: ['GET'])]
    public function show(QuestionSupport $questionSupport): Response
    {
        return $this->render('question_support/show.html.twig', [
            'question_support' => $questionSupport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_question_support_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, QuestionSupport $questionSupport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuestionSupportType::class, $questionSupport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_question_support_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('question_support/edit.html.twig', [
            'question_support' => $questionSupport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_question_support_delete', methods: ['POST'])]
    public function delete(Request $request, QuestionSupport $questionSupport,ReponseSupport $reponseSupport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponseSupport->getRefQuestion(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reponseSupport);
            $entityManager->flush();
        }
        if ($this->isCsrfTokenValid('delete'.$questionSupport->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($questionSupport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_question_support_index', [], Response::HTTP_SEE_OTHER);
    }
}