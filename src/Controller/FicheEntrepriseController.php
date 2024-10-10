<?php

namespace App\Controller;

use App\Entity\FicheEntreprise;
use App\Entity\User;
use App\Form\FicheEntrepriseFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FicheEntrepriseController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profilEntreprise', name: 'profilEntreprise')]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        $currentUser = $this->getUser();

        // Vérifier si l'utilisateur a une entreprise associée
        $entreprise = $currentUser ? $currentUser->getRefEntreprise() : null;

        // Passer l'entreprise au template
        return $this->render('fiche_entreprise/index.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    #[Route('/createFicheEntreprise', name: 'createFicheEntreprise')]
    public function create(Request $request, EntityManagerInterface $manager, Security $security)
    {
        $ficheEntreprise = new FicheEntreprise();
        $form = $this->createForm(FicheEntrepriseFormType::class, $ficheEntreprise);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ficheEntreprise);
            $manager->flush();
            $user = $security->getUser();

            if ($user) {
                $user->setRefEntreprise($ficheEntreprise);
                $manager->persist($user); // Persist the updated user
                $manager->flush(); // Save the user with the updated reference
            }
            $this->addFlash('success', 'La fiche entreprise a bien été créée');
            return $this->redirectToRoute('profilEntreprise');
        }
        return $this->render('/fiche_entreprise/createFicheEntreprise.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/showFicheEntreprise', name: 'showFicheEntreprise')]
    public function show()
    {

    }


}
