<?php

namespace App\Controller;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class CvController extends AbstractController{
    #[Route('/download-cv/{id}', name: 'download_cv')]
    public function downloadCv(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        // Récupérer le contenu du CV
        $cvContent = $user->getCv();
        $fileName = 'cv_etudiant_' . $id . '.pdf'; // Par exemple, un nom générique
        // Retourner une réponse de téléchargement
        return new Response(
            $cvContent,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }
}