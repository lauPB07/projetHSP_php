<?php

namespace App\Controller;

use App\Entity\QuestionSupport;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('admin/index.html.twig', [
            'user'=>$userRepository->findAll(),
        ]);

    }
    #[Route('/valider/{id}', name: 'app_valider')]
    public function valider(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);
        $user->setValider(1);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/refuser/{id}', name: 'app_admin_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    }
}
