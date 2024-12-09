<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/annuaire/{id}', name: 'app_sup', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin');
    }

}
