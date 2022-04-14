<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailsController extends AbstractController
{
    #[Route('/emails', name: 'emails.store', methods: ['POST'])]
    public function store(): Response
    {
        $currentDate = date('Y-m-d H:i:s');

        return $this->json([
            'message' => "Your request has been added at {$currentDate}",
        ]);
    }
}
