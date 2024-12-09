<?php

namespace App\Controller;

use App\Entity\FicheEntreprise;
use App\Entity\Offre;
use App\Entity\TypeOffre;
use App\Form\OffreFormType;
use App\Repository\OffreRepository;
use App\Repository\TypeOffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OffreController extends AbstractController
{
    //#[Route('/offre', name: 'app_offre')]
    //public function index(): Response
    //{
    //    return $this->render('offre/index.html.twig', [
   //         'controller_name' => 'OffreController',
    //    ]);
    //}

    #[Route('/createOffre', name: 'CreateOffre')]
    public function create(Request $request, EntityManagerInterface $manager, Security $security)
    {
        $offre = new Offre();
        // Récupérer l'utilisateur connecté
        $user = $security->getUser();
        $entreprises = $user ? $user->getRefEntreprise() : new FicheEntreprise();
        $form = $this->createForm(OffreFormType::class, $offre, [
            'entreprises' => $entreprises,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($user) {
                $offre->setRefUserCreer($user);
            }
            foreach ($form->get('ref_EntrepriseCreer')->getData() as $entreprise) {
                $offre->addRefEntrepriseCreer($entreprise);
            }
            $manager->persist($offre);
            $manager->flush();
            $this->addFlash('success', 'L offre a bien été créée');
            return $this->redirectToRoute('home');
        }
        return $this->render('/offre/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/showAllStages', name: 'showAllStages')]
    public function showAllStages( OffreRepository $repository): Response
    {
        // Récupérer toutes les offres de type "Stage"
        $offres = $repository->findAllStages();

        return $this->render('offre/showAllStage.html.twig', [
            'offres' => $offres,
        ]);
    }
    #[Route('/showAllEmplois', name: 'showAllEmplois')]
    public function showAllEmplois( OffreRepository $repository): Response
    {
        $offres = $repository->findAllEmplois();

        return $this->render('offre/showAllEmplois.html.twig', [
            'offres' => $offres,
        ]);
    }
    #[Route('/showAllProjets', name: 'showAllProjets')]
    public function showAllProjets( OffreRepository $repository): Response
    {
        $offres = $repository->findAllProjets();

        return $this->render('offre/showAllProjets.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/showStage', name: 'showStages')]
    public function showStages(OffreRepository $repository, Security $security): Response
    {
        $user = $security->getUser();
        $entreprises = $user->getRefEntreprise();
        $entrepriseId = $entreprises->getId();
        $offres = $repository->findStagesByEntreprise($entrepriseId);

        return $this->render('offre/showStage.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/showEmplois', name: 'showEmplois')]
    public function showEmplois(OffreRepository $repository, Security $security): Response
    {
        $user = $security->getUser();
        $entreprises = $user->getRefEntreprise();
        $entrepriseId = $entreprises->getId();
        $offres = $repository->findStagesByEntrepriseTwo($entrepriseId);

        return $this->render('offre/showEmplois.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/showProjets', name: 'showProjets')]
    public function showProjets(OffreRepository $repository, Security $security): Response
    {
        $user = $security->getUser();
        $entreprises = $user->getRefEntreprise();
        $entrepriseId = $entreprises->getId();
        $offres = $repository->findStagesByEntrepriseThree($entrepriseId);

        return $this->render('offre/showProjets.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/editOffre/{id}/edit', name: 'editEvent', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function editOffre(Offre $offre, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffreFormType::class, $offre);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            $this->addFlash('succes','L offre a bien été modifiée');
            return $this->redirectToRoute('home');
        }
        return $this->render('offre/edit.html.twig', [
            'offre' => $offre,
            'form'=>$form,
        ]);

    }

    #[Route('/{id}/delete', name:'deleteOffre', methods: ['POST'])]
    public function delete(EntityManagerInterface $entityManager, Offre $offre): Response
    {
        $entityManager->remove($offre);
        $entityManager->flush();
        $this->addFlash('success', 'L offre a bien été suprimée');
        return $this->redirectToRoute('home');

    }

    #[Route('/offre/{id}/participant',name: 'participantOffre', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function tableParticipant(int $id, OffreRepository $offreRepository): Response
    {
        $offre = $offreRepository->find($id);
        $participants = $offre->getUsers();
        return $this->render('offre/participant.html.twig', [
            'participants' => $participants,
        ]);
    }

    #[Route('/offre/{id}/participer',name: 'participerOffre', methods: ['GET','POST'])]
    public function participerOffre (int $id, OffreRepository $offreRepository, Security $security,EntityManagerInterface $entityManager): Response
    {
        // Récupération de l'utilisateur connecté
        $user = $security->getUser();

        if (!$user) {
            return new Response('Utilisateur non connecté', Response::HTTP_FORBIDDEN);
        }

        // Récupération de l'événement par son ID
        $offre = $offreRepository->find($id);

        if (!$offre) {
            return new Response('Offre non trouvé', Response::HTTP_NOT_FOUND);
        }

        // Ajout de l'utilisateur à l'événement
        $offre->addUser($user);

        $entityManager->persist($offre);
        $entityManager->flush();
        $this->addFlash("success", "Vous etes bien inscrit a l'offre");

        return $this->redirectToRoute('home');
    }
}
