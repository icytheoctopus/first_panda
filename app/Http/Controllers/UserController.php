<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;
use Validator;

class UserController extends Controller
{
    public function getUsersByCountryCode($countryCode): JsonResponse | AnonymousResourceCollection
    {
        $countryCode = strtoupper($countryCode);
        $codeIsoStandard = $this->determineISOStandard($countryCode);

        if (!$codeIsoStandard){
            return response()->json([
                'message' => 'Invalid code, please use ISO Alpha-2 or ISO Alpha-3 country code'
            ], 400);
        }

        $users = $this->getActiveUsersByCountryCode($countryCode, $codeIsoStandard);

        return UserResource::collection($users->load(['details', 'details.country']));
    }

    private function determineISOStandard($countryCode): ?string
    {
        $codeLength = strlen($countryCode);
        if ($codeLength === 2){
            return 'iso2';
        }

        if ($codeLength === 3){
            return 'iso3';
        }

        return null;
    }

    private function getActiveUsersByCountryCode($countryCode = 'AT', $codeIsoStandard = 'iso2'): Collection
    {
        return $this
            ->activeUsers()
            ->whereHas('details.country', function (Builder $query) use ($countryCode, $codeIsoStandard) {
                $query->where($codeIsoStandard, $countryCode);
            })
            ->get();
    }

    private function activeUsers()
    {
        return User::where('active', 1);
    }

    public function destroy(User $user): JsonResponse
    {
        if ($user->details()->exists()){
            return response()->json([
                'message' => 'Unable to delete user with details.'
            ], 403);
        }

        try {
            $user->deleteOrFail();
        }
        catch (Throwable $exception) {
            return response()->json([
                'message' => 'Failed to delete',
                'errors' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'User deleted'
        ], 200);
    }
}
