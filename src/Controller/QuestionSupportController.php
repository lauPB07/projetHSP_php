<?php

namespace App\Controller;

use App\Entity\QuestionSupport;
use App\Form\QuestionSupportType;
use App\Form\ReponseSupportType;
use App\Repository\QuestionSupportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/question/support')]
final class QuestionSupportController extends AbstractController
{
    #[Route('/',name: 'app_question_support_index', methods: ['GET'])]
    public function index(QuestionSupportRepository $questionSupportRepository): Response
    {
        return $this->render('question_support/index.html.twig', [
            'question_supports' => $questionSupportRepository->findAll(),

        ]);
    }

    #[Route('/new', name: 'app_question_support_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Security $security): Response
    {
        $questionSupport = new QuestionSupport();
        $user = $security->getUser();
        $form = $this->createForm(QuestionSupportType::class, $questionSupport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user) {
                $questionSupport->setRefUser($user);
            }
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
    #[Route('/{id}/reponse', name: 'app_question_support_reponse', methods: ['GET', 'POST'])]
    public function reponse(Request $request, QuestionSupport $questionSupport, EntityManagerInterface $entityManager,Security $security): Response
    {
        $user = $security->getUser();
        $form = $this->createForm(ReponseSupportType::class, $questionSupport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user) {
                $questionSupport->setRefAdmin($user);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_question_support_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('question_support/reponse.html.twig', [
            'question_support' => $questionSupport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_question_support_delete', methods: ['POST'])]
    public function delete(Request $request, QuestionSupport $questionSupport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$questionSupport->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($questionSupport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_question_support_index', [], Response::HTTP_SEE_OTHER);
    }
}
