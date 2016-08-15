<?php

  $routes->get('/mon', function() {
	MonController::index();
});

  $routes->get('/mon/:id', function($id) {
	MonController::show($id);
});

  $routes->get('/mons', function() {
	HelloWorldController::mon_list();
});

  $routes->get('/login', function() {
	HelloWorldController::login();
});

  $routes->get('/mons/1', function() {
	HelloWorldController::mon_show();
});

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
