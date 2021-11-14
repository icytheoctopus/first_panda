<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Validator;

class UserDetailsController extends Controller
{
    public function update(Request $request, UserDetails $userDetails): JsonResponse
    {
        $userDetailsData = $request->only([
            'first_name',
            'last_name',
            'phone_number',
            'citizenship_country_id'
        ]);

        $validator = Validator::make($userDetailsData, [
            'first_name' => ['sometimes', 'required', 'min:2', 'max:50'],
            'last_name' => ['sometimes', 'required', 'string', 'min:2', 'max:50'],
            'phone_number' => ['sometimes','required','string'],
            'citizenship_country_id'=> ['sometimes', 'required', 'integer', 'exists:App\Models\Country,id'],
        ]);

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
}
