<?php

define("DIRECTORY", __DIR__);

session_start();

require 'vendor/autoload.php';
require 'core/bootstrap.php';

use App\Core\{Router, Request};

Router::load('app/routes.php')->direct(Request::uri(), Request::method());
