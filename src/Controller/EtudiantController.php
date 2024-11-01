<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EtudiantController extends AbstractController
{
        #[Route('/etudiant', name: 'app_etudiant')]
    public function index(UserRepository $user): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'user'=> $user->findAll(),
        ]);
    }
}
