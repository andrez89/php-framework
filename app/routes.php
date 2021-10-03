 <?php

   // Gestione Dashboard, Homepage ---------------------------------------------

   $router->get('',             'HomeController@home');
   $router->get('dashboard',    'HomeController@dashboard');
   $router->get('unauthorized', 'HomeController@unauthorized');
   $router->get('info',         'HomeController@info');

   //---------------------------------------------------------------------------

   // Gestione Login/Logout ----------------------------------------------------

   $router->post('',        'LoginController@login');
   $router->get('logout',  'LoginController@logout');
   $router->post('forget',  'LoginController@forget');
   $router->get('recover', 'LoginController@recover');
   $router->post('recover', 'LoginController@recoverPasswords');
