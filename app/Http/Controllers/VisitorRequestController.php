<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitorApiRequest;
use App\Services\Visitor;
use RuntimeException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Spec as OA;

#[OA\Info(title: 'WeIntegral Website API', version: '0.1')]
class VisitorRequestController extends Controller
{
    public function __construct(
        private Visitor $visitor
    ){}

    #[OA\Operation\Post(
        path: '/api/visitor-request',
        summary: 'Create a new visitor request',
        tags: ['Visitor Request'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType\Json(
                type: 'object',
                properties: [
                    'name' => new OA\Schema(type: 'string', example: 'John Doe'),
                    'email' => new OA\Schema(type: 'string', example: 'john.doe@example.com'),
                    'subject' => new OA\Schema(type: 'string', example: 'Email Subject'),
                    'message' => new OA\Schema(type: 'string', example: 'Email Message content'),
                ],
            ),
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Visitor request created successfully',
                content: new OA\MediaType\Json(
                    type: 'object',
                    properties: [
                        'message' => new OA\Schema(type: 'string', example: 'Visitor request created successfully'),
                        'data' => new OA\Schema(type: 'object', properties: [
                            'name' => new OA\Schema(type: 'string', example: 'John Doe'),
                            'email' => new OA\Schema(type: 'string', example: 'john.doe@example.com'),
                            'subjectOfEmail' => new OA\Schema(type: 'string', example: 'Subject'),
                            'messageOfEmail' => new OA\Schema(type: 'string', example: 'Message content'),
                        ]),
                    ],
                ),
            ),
            new OA\Response(
                response: 500,
                description: 'Error creating visitor request',
                content: new OA\MediaType\Json(
                    type: 'object',
                    properties: [
                        'message' => new OA\Schema(type: 'string', example: 'Error creating visitor request'),
                    ],
                ),
            ),
        ],
    )]
    public function createAction(VisitorApiRequest $request): JsonResponse
    {
        try {
            //Step1: Validate the request
            $validatedData = $request->validated();

            //Step2: Create the visitor request
            $this->visitor->createRequest($validatedData);
        } catch (RuntimeException) {
            return response()->json([
                'message' => 'Error creating visitor request'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Visitor request created successfully',
            'data' => $validatedData
        ], Response::HTTP_CREATED);
    }
}
