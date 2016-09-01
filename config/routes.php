<?php

  $routes->get('/pokedex/:id', function($id) {
	MonController::dexindex($id);
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

  $routes->post('/mon/destroy/:id/:trainer_id', function($id, $trainer_id) {
	MonController::destroy_mon($id, $trainer_id);
});

  $routes->post('/destroydex/:id/:trainer_id', function($id, $trainer_id) {
	MonController::destroy_dex($id, $trainer_id);
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
	UserController::destroy_trainer_keep_public_dex($id);
});

  $routes->post('/user/destroyall/:id', function($id) {
	UserController::destroy_trainer_and_pokemons($id);
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
