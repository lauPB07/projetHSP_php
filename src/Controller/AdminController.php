<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
