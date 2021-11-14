<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class UserController extends Controller
{
    public function getUsersByCountryCode($countryCode)
    {
        $countryCode = strtoupper($countryCode);
        if ($codeIsoStandard = $this->determineISOStandard($countryCode)){
            return $this->getActiveUsersByCountryCode($countryCode, $codeIsoStandard);
        }
        return response("Invalid code, please use ISO Alpha-2 or ISO Alpha-3 country code", 400);
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

    private function getActiveUsersByCountryCode($countryCode = 'AT', $codeIsoStandard = 'iso2') : Collection
    {
        return $this->activeUsers()->whereHas('user_details', function (Builder $userDetailsQuery) use ($countryCode, $codeIsoStandard) {
            $userDetailsQuery->whereHas('country', function (Builder $countryQuery) use ($countryCode, $codeIsoStandard) {
                $countryQuery->where($codeIsoStandard, $countryCode);
            });
        })->get();
    }

    private function activeUsers()
    {
        return User::where('active', 1);
    }

    public function destroy(User $user)
    {
        if ($user->user_details()->exists()){
            return response("Unable to delete user with details.", 403);
        }

        try {
            $user->deleteOrFail();
            return response("User deleted", 200);
        }
        catch (Throwable $e) {
            return response("Failed to delete", 500);
        }
    }
}
