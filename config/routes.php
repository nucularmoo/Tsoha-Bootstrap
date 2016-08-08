<?php

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
