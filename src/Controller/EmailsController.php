<?php

namespace App\Controller;

use App\Actions\StoreEmailAddressAction;
use App\RequestDataTransferObjects\StoreEmailAddressRequestDataTransferObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EmailsController extends AbstractController
{
    #[Route(path: '/api/v1/emails', name: 'api.v1.emails.store', methods: ['POST'])]
    public function store(Request $request, StoreEmailAddressAction $action): JsonResponse
    {
        $responseDataTransferObject = $action->execute(requestDataTransferObject: StoreEmailAddressRequestDataTransferObject::fromRequest($request));

        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);

        return $this->json(
            data: $serializer->serialize(
                data: $responseDataTransferObject,
                format: 'json',
                context: [AbstractNormalizer::ATTRIBUTES => ['message']]
            ),
            status: $responseDataTransferObject->getStatusCode()
        );
    }
}
