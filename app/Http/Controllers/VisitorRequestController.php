<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitorApiRequest;
use App\Services\Visitor;
use http\Exception\RuntimeException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VisitorRequestController extends Controller
{
    public function __construct(
        private Visitor $visitor
    ){}

    public function createAction(VisitorApiRequest $request): JsonResponse
    {
        try {
            //Step1: Validate the request
            $validatedData = $request->validated();

            //Step2: Create the visitor request
            $this->visitor->create($validatedData);
        } catch (RuntimeException) {
            return response()->json([
                'message' => 'Error creating visitor request'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Customer request created successfully',
            'data' => $validatedData
        ], Response::HTTP_CREATED);
    }
}
