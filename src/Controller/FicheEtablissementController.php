<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\FicheEtablissement;
use App\Entity\User;
use App\Form\FicheEtablissementFormType;
use App\Form\OffreFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\SubmitType;

class FicheEtablissementController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profilEtablissement', name: 'profilEtablissement')]
    public function index(): Response
    {
        $currentUser = $this->getUser();

        $etablissement = $currentUser ? $currentUser->getRefEtablissement() : null;

        return $this->render('fiche_etablissement/index.html.twig', [
            'etablissement' => $etablissement,
        ]);
    }

    #[Route('/createFicheEtablissement', name: 'createFicheEtablissement')]
    public function create(Request $request, EntityManagerInterface $manager, Security $security)
    {
        $ficheEtablissement = new FicheEtablissement();
        $form = $this->createForm(FicheEtablissementFormType::class, $ficheEtablissement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ficheEtablissement);
            $manager->flush();
            $user = $security->getUser();

            if ($user) {
                $user->setRefEtablissement($ficheEtablissement);
                $manager->persist($user);
                $manager->flush();
            }
            $this->addFlash('success', 'La fiche etablissement a bien été créée');
            return $this->redirectToRoute('profilEtablissement');
        }
        return $this->render('/fiche_etablissement/createFicheEtablissement.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/editFicheEtablissement/{id}/edit', name: 'editFicheEtablissement')]
    public function edit(FicheEtablissement $ficheEtablissement,Request $request, EntityManagerInterface $entityManager):Response
    {
        $form = $this->createForm(FicheEtablissementFormType::class, $ficheEtablissement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            $this->addFlash('succes','L offre a bien été modifiée');
            return $this->redirectToRoute('home');
        }
        return $this->render('fiche_etablissement/edit.html.twig', [
            'ficheEtablissement' => $ficheEtablissement,
            'form'=>$form,
        ]);
    }

    #[Route('/rattacherFicheEtablissement', name: 'rattacherFicheEtablissement')]
    public function afficherToutetEtablissement(EntityManagerInterface $em): Response
    {
        $etablissement = $em->getRepository(FicheEtablissement::class)->findAll();
        return $this->render('fiche_etablissement/attacherFicheEtablissement.html.twig', [
            'controller_name' => 'EventController',
            'etablissement' => $etablissement,
        ]);
    }

    #[Route('/rattacherUserFicheEta/{id}', name: 'rattacherUserFicheEta', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function attacherUserFicheEtablissement(EntityManagerInterface $em, int $id, Security $security, EntityManagerInterface $manager ): Response
    {
        $etablissement = $em->getRepository(FicheEtablissement::class)->find($id);
        $user = $security->getUser();
        if ($user) {
            $user->setRefEtablissement($etablissement);
            $manager->persist($user);
            $manager->flush();
        }
        $this->addFlash('success', 'La fiche etablissement a bien été attribué');
        return $this->redirectToRoute('profilEtablissement');


    }


}
