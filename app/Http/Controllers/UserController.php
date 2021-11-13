<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function activeUsers()
    {
        return User::where('active', 1);
    }

    public function getActiveAustrians()
    {
        return $this->getActiveUsersByCountryName('Austria');
    }

    private function getActiveUsersByCountryName($countryName = 'Austria')
    {
        return $this->activeUsers()->whereHas('user_details', function(Builder $query) use ($countryName) {
            $query->whereHas('country', function (Builder $subQuery) use ($countryName) {
                $subQuery->where('name',$countryName);
            });
        })->get();
    }

    public function delete(User $user){
        if ($user->user_details()->exists()){
            return response("Can't delete User that has UserDetails");
        }

        $user->deleteOrFail();
        return response("User deleted");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
