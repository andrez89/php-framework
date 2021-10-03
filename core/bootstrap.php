<?php

use App\Core\App;
use App\Core\Database\{QueryBuilder, Connection};

App::bind('database', new QueryBuilder(
    Connection::make(App::get('config')['database'])
));
