<?php

namespace App\Controller;

use App\Actions\StoreEmailAddressAction;
use App\DataTransferObjects\StoreEmailAddressRequestDataTransferObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EmailsController extends AbstractController
{
    #[Route(path: '/api/v1/emails', name: 'api.v1.emails.store', methods: ['POST'])]
    public function store(Request $request, StoreEmailAddressAction $action): JsonResponse
    {
        $responseDataTransferObject = $action->execute(requestDataTransferObject: StoreEmailAddressRequestDataTransferObject::fromRequest($request));

        return $this->json(data: [
            'message' => $responseDataTransferObject->getMessage(),
        ], status: $responseDataTransferObject->getStatusCode());
    }
}
