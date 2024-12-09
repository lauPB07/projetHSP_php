<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\FicheEntreprise;
use App\Entity\Post;
use App\Entity\Reponse;
use App\Form\FicheEntrepriseFormType;
use App\Form\PostType;
use App\Form\ReponseType;
use App\Repository\PostRepository;
use App\Repository\ReponseRepository;
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

    #[Route('/reponse/{id}', name: 'app_reponse', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function reponse(EntityManagerInterface $em, PostRepository $repositorypost,ReponseRepository $repository, int $id): Response
    {
        $posts = $repositorypost->find($id);
        $reponses = $repository->findReponsesById($posts->getId());
        return $this->render('forum/reponse.html.twig', [
            'controller_name' => 'RepondreController',
            'posts' => [$posts],
            'reponses' => $reponses,
        ]);
    }

    #[Route('/createReponse/{id}', name: 'app_createReponse', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function createReponse(Request $request, EntityManagerInterface $manager, Security $security, int $id, PostRepository $repositorypost): Response
    {
        $reponse = new Reponse();
        $post = $repositorypost->find($id);
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $security->getUser();
            if ($user) {
                $reponse->setRefUser($user);
                $reponse->setRefPost($post);
            }
            $manager->persist($reponse);
            $manager->flush();

            $this->addFlash('success', 'La réponse a bien été créée.');

            return $this->redirectToRoute('app_forum');
        }

        return $this->render('/forum/createReponse.html.twig', [
            'form' => $form->createView(),
        ]);
    }





}
