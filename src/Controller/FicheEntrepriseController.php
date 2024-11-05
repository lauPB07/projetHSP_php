<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\FicheEntreprise;
use App\Entity\User;
use App\Form\FicheEntrepriseFormType;
use App\Form\OffreFormType;
use App\Repository\FicheEntrepriseRepository;
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
    public function index(FicheEntrepriseRepository $entrepriseRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $currentUser = $this->getUser();

        // Vérifier si l'utilisateur a une entreprise associée
        $entreprise = $currentUser ? $currentUser->getRefEntreprise() : null;

        // Passer l'entreprise au template
        return $this->render('fiche_entreprise/index.html.twig', [
            'entreprise' => $entreprise,
            'entreprises' => $entrepriseRepository->findAll(),
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

    #[Route('/editFicheEntreprise/{id}/edit', name: 'editFicheEntreprise')]
    public function edit(FicheEntreprise $ficheEntreprise,Request $request, EntityManagerInterface $entityManager):Response
    {
        $form = $this->createForm(FicheEntrepriseFormType::class, $ficheEntreprise);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            $this->addFlash('succes','L offre a bien été modifiée');
            return $this->redirectToRoute('home');
        }
        return $this->render('fiche_entreprise/edit.html.twig', [
            'ficheEntreprise' => $ficheEntreprise,
            'form'=>$form,
        ]);
    }

    #[Route('/rattacherFicheEntreprise', name: 'rattacherFicheEntreprise')]
    public function afficherToutetEntreprise(EntityManagerInterface $em): Response
    {
        $entreprises = $em->getRepository(FicheEntreprise::class)->findAll();
        return $this->render('fiche_entreprise/attacherFicheEntreprise.html.twig', [
            'controller_name' => 'EventController',
            'entreprises' => $entreprises,
        ]);
    }

    #[Route('/rattacherUserFicheEnt/{id}', name: 'rattacherUserFicheEnt', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function attacherUserFicheEntreprise(EntityManagerInterface $em, int $id, Security $security, EntityManagerInterface $manager ): Response
    {
        $entreprise = $em->getRepository(FicheEntreprise::class)->find($id);
        $user = $security->getUser();
        if ($user) {
            $user->setRefEntreprise($entreprise);
            $manager->persist($user);
            $manager->flush();
        }
        $this->addFlash('success', 'La fiche entreprise a bien été attribué');
        return $this->redirectToRoute('profilEntreprise');


    }


}
