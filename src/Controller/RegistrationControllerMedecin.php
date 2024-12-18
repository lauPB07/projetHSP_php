<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormTypeEtudiant;
use App\Form\RegistrationFormTypeMedecin;
use App\Repository\RoleRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationControllerMedecin extends AbstractController
{

    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

    #[Route('/registerMedecin', name: 'app_registerMedecin')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager,RoleRepository $roleRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormTypeMedecin::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setMdp($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setRefRole($roleRepository->find($form->get('ref_role')->getData()));
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $this->emailVerifier->sendEmailConfirmation('app_verifyEmailMedecin', $user,
                (new TemplatedEmail())
                    ->from(new Address('projethspcontact@gmail.com', 'projethspcontact'))
                    ->to((string) $user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/registerMedecin.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify/emailMedecin', name: 'app_verifyEmailMedecin')]
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

            return $this->redirectToRoute('app_registerMedecin');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_login');
    }

    #[Route('/editMedecin/{id}', name: 'registerEditMedecin', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(RegistrationFormTypeMedecin::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            $this->addFlash('succes','L evenement a bien été modifiée');
            return $this->redirectToRoute('home');
        }
        return $this->render('registration/editMedecin.html.twig', [
            'user' => $user,
            'form'=>$form,
        ]);
    }
}
