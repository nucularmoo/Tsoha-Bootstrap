<?php

	/**
	 * Luokka UserController vastaa kirjautuneen käyttäjän käyttäjään liittyvien näkymien luomisesta ja hallinnoimisesta
	 * sekä välittää tallennettavat, muutettavat tai poistettavat tiedot Trainer-tietokohteisiin liittyen luokalle user.php
	 */

	class UserController extends BaseController{

		/**
		 * Metodi show hakee parametrina annetun Trainer-tietokohteen tunnisteen perusteella tietokohteen
		 * tietosisällön sekä kaikki Team-tietokohteen tietosisällöt, jonka jälkeen se luo käyttäjälle
		 * asianmukaisen näkymän
		 */		
	
		public static function show($id) {

			
			$teams = Team::all();
			$trainer = User::find($id);

			View::make('user/view.html', array('teams' => $teams, 'trainer' => $trainer));

		}

		/**
		 * Metodi edit ottaa parametrina Trainer-tietokohteen tunnisteen jonka jälkeen se luo käyttäjälle
		 * asianmukaisen näkymän Trainer-tietokohteen tietosisällön muokkaamista varten
		 */

		public static function edit($id) {

			$teams = Team::all();
			$attributes = User::find($id);

			View::make('user/edit.html', array('teams' => $teams, 'attributes' => $attributes));

		}

		/**
		 * Metodi login luo sisäänkirjautumissivun näkymän
		 */

		public static function login(){
		      View::make('user/login.html');

 		}

		/**
		 * Metodi handle_login on vastuussa sisäänkirjautumissivun lomakkeen tietojen käsittelystä ja niiden oikeellisuuden varmistamisesta ja näin
		 * lopullisesti vastuussa käyttäjän sisäänkirjautumisessa sekä session aloittamisessa
		 */

		public static function handle_login(){
   			$params = $_POST;

			$user = User::authenticate($params['username'], $params['password']);

	   		if(!$user){
     				View::make('user/login.html', array('error' => 'Wrong usermame or password!', 'username' => $params['username']));
   			} else {
 			 	$_SESSION['user'] = $user->id;

     				 Redirect::to('/', array('message' => 'Welcome back ' . $user->name . '!'));
   			}
 		 }

		/**
		 * Metodi logout on vastuussa uloskirjautumisen toteuttamisessa sekä uloskirjautumisen yhteydessä uloskirjautuvan käyttäjän session päättämisessä
		 */

		public static function logout(){
			$_SESSION['user'] = null;
			Redirect::to('/', array('message' => 'You have been signed out!'));
		}

		/**
		 * Metodi create on vastuussa uuden käyttäjän rekisteröitymistä varten tarvittavan lomakesivun näkymän luomisesta
		 */

		public static function create() {

			$teams = Team::all();
			View::make('user/new.html', array('teams' => $teams));

		}

		/**
		 * Metodi store on vastuussa rekisteröityvän käyttäjän Trainer-tietokohteen tietosisällön tallennuksen validoinnin varmistamisesta
		 * sekä tietokohteen tietosisällön välityksestä tiedot tallentavaan user.php-luokkaan ja lopuksi käyttäjän uudelleenohjaamisesta
		 * asianmukaiselle sivulle
		 */

		public static function store() {

			$teams = Team::all();

			$params = $_POST;

			$team_id = $params['team_id'];

			$attributes = array(

				'name' => $params['name'],
				'password' => $params['password'],
				'team_id' => $team_id

			);

			$user = new User($attributes);

			$errors = $user->errors();

			if(count($errors) == 0) {

				$user->save();

				Redirect::to('/login' , array('message' => 'Account created! Welcome aboard, trainer!'));

			} else {

				View::make('user/new.html', array('errors' => $errors, 'teams' => $teams, 'attributes' => $attributes));

			}

		}

		/**
		 * Metodi update on vastuussa jo olemassaolevan Trainer-tietokohteen tietosisällön päivityksen validoinnin
		 * varmistamisesta sekä päivitetyn Trainer-tietokohteen tietosisällön välityksestä tiedot päivittävään
		 * user.php-luokkaan ja lopuksi käyttäjän uudelleenohjaamisesta asianmukaiselle sivulle
		 */

		public static function update($id) {

			$teams = Team::all();

			$params = $_POST;

			$team_id = $params['team_id'];

			$attributes = array(
				'id' => $id,
				'name' => $params['name'],
				'password' => $params['password'],
				'team_id' => $team_id
			);

			$user = new User($attributes);
			$errors = $user->errors();

			if(count($errors) > 0) {

				View::make('/user/edit.html', array('errors' => $errors, 'teams' => $teams, 'attributes' => $attributes));

			} else {

				$user->update();

				Redirect::to('/user/view/'. $user->id, array('message' => 'Edit successful!'));

			}

		}

		/**
		 * Metodi destroy_trainer_keep_public_dex ottaa parametrina Trainer-tietokohteen tunnisteen,
		 * ja on vastuussa kyseisen Trainerin tunnisteeseen liitetyn Pokedex-viitteiden poistokäskyn
		 * välittämisestä edelleen pokedex.php-luokalle, jonka jälkeen metodi välittää käskyn poistaa kyseisen
		 * Trainer-tietokohteen tietosisällön tietokannasta luokalle user.php
		 */

		public static function destroy_trainer_keep_public_dex($id) {

			$pokedex = new Pokedex(array('trainer_id' => $id));

			$pokedex->destroy_all_by_trainer_keep_public_dex();

			$user = new User(array('id' => $id));

			$user->destroy();

			Redirect::to('/', array('message' => 'Account successfully deleted!'));

		}

		/**
		 * Metodi destroy_trainer_and_pokemons ottaa parametrina Trainer-tietokohteen tunnisteen,
		 * ja on vastuussa kyseisen Trainerin tunnisteeseen liitetyn Pokedex-viitteiden ja myös 
		 * näihin viitattavien Pokemon-tietokohteiden tietosisällön poistokäskyn välittämisestä 
		 * edelleen pokedex.php-luokalle, jonka jälkeen metodi välittää käskyn poistaa kyseisen
		 * Trainer-tietokohteen tietosisällön tietokannasta luokalle user.php
		 */
 
		public static function destroy_trainer_and_pokemons($id) {

			$pokedex = new Pokedex(array('trainer_id' => $id));

			$pokedex->destroy_all_by_trainer();

			$user = new User(array('id' => $id));

			$user->destroy();

			Redirect::to('/', array('message' => 'Account and Pokémons successfully deleted!'));

		}

	}
