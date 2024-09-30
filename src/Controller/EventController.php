<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
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

}