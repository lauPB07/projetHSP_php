<?php

namespace App\Controller;

use Mailjet\Client;
use Mailjet\Resources;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $name): Response
    {
        $mj = new Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'],true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "projethsp0@gmail.com",
                        'Name' => "Me"
                    ],
                    'To' => [
                        [
                            'Email' => "djibrilkorchi@yopmail.com",
                            'Name' => "You"
                        ]
                    ],
                    'Subject' => "My first Mailjet Email!",
                    'TextPart' => "Greetings from Mailjet!",
                    'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href=\"https://www.mailjet.com/\">Mailjet</a>!</h3>
            <br />May the delivery force be with you!"
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);

        $response->success() && var_dump($response->getData());
        return $this->render('home/index.html.twig');
    }
}
