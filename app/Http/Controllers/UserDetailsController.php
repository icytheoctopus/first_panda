<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Validator;

class UserDetailsController extends Controller
{
    public function updateDetailsForUser(Request $request, User $user): JsonResponse
    {
        $userDetails = $user->getUserDetails();
        if (!$userDetails){
            return response()->json([
                'message' => 'User has no details that we could update',
            ], 403);
        }

        return $this->update($request, $userDetails);
    }

    public function update(Request $request, UserDetails $userDetails): JsonResponse
    {
        $validator = $this->validateRequest($request);
        if ($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->messages()->get('*'),
            ], 400);
        }

        try {
            $userDetails->updateOrFail($validator->validated());
        }
        catch (Throwable $exception) {
            return response()->json([
                'message' => 'Update failed',
                'errors' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'User details updated'
        ], 200);
    }

    private function validateRequest(Request $request){
        $userDetailsData = $request->only([
            'first_name',
            'last_name',
            'phone_number',
            'citizenship_country_id'
        ]);

        return Validator::make($userDetailsData, UserDetails::$validationRules);
    }
}
