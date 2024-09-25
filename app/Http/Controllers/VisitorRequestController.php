<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitorApiRequest;
use App\Services\Visitor;
use http\Exception\RuntimeException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(title="My First API", version="0.1")
 */
class VisitorRequestController extends Controller
{
    public function __construct(
        private Visitor $visitor
    ){}

    /**
     * @OA\Post(
     *     path="/api/visitor-request",
     *     summary="Create a new visitor request",
     *     tags={"Visitor Request"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="subject", type="string", example="Email Subject"),
     *             @OA\Property(property="message", type="string", example="Email Message content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Visitor request created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Visitor request created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *                 @OA\Property(property="subjectOfEmail", type="string", example="Subject"),
     *                 @OA\Property(property="messageOfEmail", type="string", example="Message content")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error creating visitor request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error creating visitor request")
     *         )
     *     )
     * )
     */
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
