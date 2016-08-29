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

  $routes->get('/user/view/:id', function($id) {
	UserController::show($id);
});

  $routes->get('/user/edit/:id', function($id) {
	UserController::edit($id);
});

  $routes->post('/user/edit/:id', function($id) {
	UserController::update($id);
});

  $routes->post('/user/destroy/:id', function($id) {
	UserController::destroy($id);
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

  $routes->post('/user/new', function() {
	UserController::store();
});

  $routes->get('/user/new', function() {
	UserController::create();
});

  $routes->get('/', function() {
	PublicController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
