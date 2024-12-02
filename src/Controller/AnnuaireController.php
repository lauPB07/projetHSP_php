<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnuaireController extends AbstractController
{

        #[Route('/Etudiant', name: 'app_etudiant')]
        public function index(UserRepository $user): Response
    {
        return $this->render('Annuaire/index.html.twig', [
            'user'=> $user->findAll(),
        ]); 
    }
    #[Route('/Medecin', name: 'app_medecin')]
    public function indexEtudiant(UserRepository $user): Response{

        return $this->render('Annuaire/indexEtudiant.html.twig', [

            'user'=> $user->findAll(),
            'img' => base64_encode($user->find('cv')),
        ]);
    }
    #[Route('/Admin', name: 'app_partenaire')]
    public function indexAdmin(UserRepository $user): Response
    {
        return $this->render('Annuaire/indexPartenaire.html.twig', [
            'user'=> $user->findAll(),
        ]);
    }

}
