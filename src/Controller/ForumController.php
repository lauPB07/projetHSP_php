<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\FicheEntreprise;
use App\Entity\Post;
use App\Form\FicheEntrepriseFormType;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/create', name: 'createPost')]
    public function createPost(Request $request, EntityManagerInterface $manager, Security $security): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($post);
            $manager->flush();
            $user = $security->getUser();

            if ($user) {
                $post->setRefUser($user);
                $manager->persist($post); // Persist the updated user
                $manager->flush(); // Save the user with the updated reference
            }
            $this->addFlash('success', 'La question a bien été créée');
            return $this->redirectToRoute('app_forum');
        }
        return $this->render('/forum/createQuestion.html.twig', [
            'form' => $form
        ]);
    }
}
