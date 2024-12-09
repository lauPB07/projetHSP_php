<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\ModifMdpType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ModifMdpControlleur extends AbstractController
{
    #[Route('/edit', name: 'app_modif', methods: ['GET', 'POST'])]
    public function changePassword(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response {
        $user = $this->getUser();

        $form = $this->createForm(ModifMdpType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            $newPassword = $form->get('plainPassword')->getData();

            // Vérifier que l'ancien mot de passe est valide
            if (!$userPasswordHasher->isPasswordValid($user, $oldPassword)) {
                $this->addFlash('danger', 'L\'ancien mot de passe est incorrect.');
                return $this->redirectToRoute('app_modif');
            }


            $hashedPassword = $userPasswordHasher->hashPassword($user, $newPassword);
            $user->setMdp($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été changé avec succès.');

            return $this->redirectToRoute('home');
        }

        return $this->render('modifMdp/index.html.twig', [
            'form' => $form,
        ]);
    }
}