<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RegistrationFormTypeEtudiant;
use App\Repository\RoleRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationControllerEtudiant extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }
    #[Route('/registration', name: 'inscription')]
    public function inscription()
    {
        return $this->render('registration/inscription.html.twig');
    }

    #[Route('/registerEtudiant', name: 'app_registerEtudiant')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, RoleRepository $roleRepository, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormTypeEtudiant::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setMdp($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setRefRole($roleRepository->find($form->get('ref_role')->getData()));
            $entityManager->persist($user);

            // generate a signed url and email it to the user
               $email = (new TemplatedEmail())
                    ->from('projethspcontact@gmail.com')
                    ->to((string) $user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig');

            try {
                $mailer->send($email);

            } catch (TransportExceptionInterface $e) {
                $this->addFlash("danger", $email->generateMessageId() ." : l'email en question n'a pas recu votre envoi");
            }

            $entityManager->flush();

            // do anything else you need here, like send an email
            return $this->redirectToRoute('home');
        }


        $this->addFlash("danger"," : bbbbbb");
        return $this->render('registration/registerEtudiant.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify/emailEtudiant', name: 'app_verifyEmailEtudiant')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            /** @var User $user */
            $user = $this->getUser();
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_registerEtudiant');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_login');
    }

    #[Route('/editEtudiant/{id}', name: 'registerEditEtudiant', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(RegistrationFormTypeEtudiant::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            $this->addFlash('succes','L evenement a bien été modifiée');
            return $this->redirectToRoute('home');
        }
        return $this->render('registration/editEtudiant.html.twig', [
            'user' => $user,
            'form'=>$form,
        ]);
    }
}
