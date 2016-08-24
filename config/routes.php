<?php

  $routes->get('/mon', function() {
	MonController::index();
});

  $routes->post('/mon', function() {
	MonController::store();
});

  $routes->get('/mon/new', function() {
	MonController::create();
});

  $routes->get('/mon/:id', function($id) {
	MonController::show($id);
});

  $routes->get('/mon/edit/:id', function($id) {
	MonController::edit($id);
});

  $routes->post('/mon/edit/:id', function($id) {
	MonController::update($id);
});

  $routes->post('/mon/destroy/:id', function($id) {
	MonController::destroy($id);
});

  $routes->get('/login', function() {
	UserController::login();
});

  $routes->post('/login', function() {
	UserController::handle_login();
});

 $routes->post('/logout', function() {
	UserController::logout();
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
