<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginated_users = User::orderBy('id', 'desc')->paginate(10);
        $users           = $paginated_users
                            ->getCollection()
                            ->map(function($item) {
                                return [
                                    'id' => $item->id,
                                    'name' => $item->name,
                                    'email' => $item->email
                                ];
                            })->toArray();


        return view('users.index' , ['users' => $users , 'pagination' => $paginated_users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genders = [
            'male'   => 'Male',
            'female' => 'Female',
            'other'  => 'Other'
        ];
        return view('users.create' , ['genders' => $genders]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
