<?php

namespace App\Controllers;

use App\Core\App;

class HomeController
{
    /**
     * Show the home page.
     */
    public function home()
    {
        if (isLoggedIn()) {
            return redirect('dashboard');
        } else {
            return view('pages/login', ["url" => isset($_GET["url"]) ? $_GET["url"] : ""]);
        }
    }

    public function dashboard()
    {

        if (isLoggedIn()) {
        } else {
            expiredSession();
        }
    }

    /**
     * Show the 404 Page.
     */
    public function notFound()
    {
        if (isLoggedIn()) {
            http_response_code(404);
            return view('pages/notfound');
        } else {
            expiredSession();
        }
    }

    /**
     * Show the 404 Page.
     */
    public function unauthorized()
    {
        if (isLoggedIn()) {
            http_response_code(401);
            return view('pages/unauthorized');
        } else {
            expiredSession();
        }
    }

    /**
     * Show the info Page.
     */
    public function info()
    {
        if (isLoggedIn()) {
            return view('pages/info');
        } else {
            expiredSession();
        }
    }
}
