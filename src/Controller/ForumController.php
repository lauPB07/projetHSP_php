<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ForumController extends AbstractController
{
    #[Route('/forum', name: 'app_forum')]
    public function index(EntityManagerInterface $em): Response
    {
        $questions = $em->getRepository(Post::class)->findAll();
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'questions' => $questions,
        ]);
    }
}
