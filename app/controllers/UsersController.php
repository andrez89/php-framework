<?php

namespace App\Controllers;

use App\Core\App;

class UsersController
{
    /**
     * Show all users.
     */
    public function index()
    {
        $users = App::get('database')->selectAll('users');

        return view('users', ['users' => $users]);
    }

    /**
     * Store a new user in the database.
     */

    public function store()
    {
        App::get('database')->insert('users', [
            'name' => $_POST['name']
        ]);

        return redirect('users');
    }

    public function datiApi()
    {
        if (isLoggedIn()) {
            json(App::get('database')->selectAll('users'));
        }
    }
}
