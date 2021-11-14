<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use Illuminate\Http\Request;

class UserDetailsController extends Controller
{
    public function update(Request $request, UserDetails $userDetails)
    {
        $userDetailsData = $request->only([
            'first_name',
            'last_name',
            'phone_number',
            'country'
        ]);
    }
}
