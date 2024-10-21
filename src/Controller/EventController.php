<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'event')]
    public function index(EntityManagerInterface $em,Security $security): Response
    {
        $events = $em->getRepository(Event::class)->findAll();
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
            'events' => $events,
        ]);
    }

    #[Route('/api/events', name: 'get_events', methods: ['GET'])]
    public function getEvents(Request $request, EventRepository $eventRepository): JsonResponse
    {
        // Récupérer les paramètres de date depuis la requête
        $dateString = $request->query->get('date');

        // Vérifiez si la date est fournie et si elle est au format correct
        if ($dateString) {
            // Utiliser le repository pour trouver les événements par date
            $events = $eventRepository->findBy([
                'date' => new \DateTime($dateString), // Conversion directe de la chaîne de date
            ]);
        } else {
            // Gérer le cas où aucune date n'est fournie, par exemple en retournant une liste vide ou une erreur
            $events = [];
        }

        // Transformer les événements en tableau associatif pour le retour JSON
        $eventData = [];
        foreach ($events as $event) {
            $eventData[] = [
                'id' => $event->getId(),
                'type' => $event->getType(),
                'titre' => $event->getTitre(),
                'description' => $event->getDescription(),
                'rue' => $event->getRue(),
                'cp' => $event->getCp(),
                'ville' => $event->getVille(),
                'element_sup' => $event->getElementSup(),
                'date' => $event->getDate()->format('Y-m-d'),
                'nbPlace' => $event->getNbPlace(),
                'participants' => count($event->getRefUserParticipe()),  // Nombre de participants
            ];
        }

        // Retourner les événements en JSON
        return new JsonResponse(['events' => $eventData]);
    }

    #[Route('/createEvent', name: 'createEvent')]
    public function create(Request $request, EntityManagerInterface $em, Security $security)
    {
        $event = new Event();
        $user = $security->getUser();
        $form = $this->createForm(EventFormType::class,$event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($user){
                $event->addUser($user);
            }
            $em->persist($event);
            $em->flush();
            $this->addFlash('success', 'L evenement a bien été créée');
            return $this->redirectToRoute('home');
        }
        return $this->render('/event/createEvent.html.twig', [
            'form' => $form
        ]);
    }

}
