<?php
	class UserController extends BaseController{

		/**
		 * metodi show on vastuussa sille parametrina annetun tunnisteen välittäminen tiedot tietokannasta hakevalle user.php luokalle
		 * sekä näitä tietoja käyttäen trainerin tietokohteen näyttävän sivun tekeminen
		 */		
	
		public static function show($id) {

			
			$teams = Team::all();
			$trainer = User::find($id);

			View::make('user/view.html', array('teams' => $teams, 'trainer' => $trainer));

		}

		/**
		 * metodi edit on vastuussa sille parametrina annetun tunnisteen välittäminen tiedot tietokannasta hakevalle user.php luokalle
		 * sekä näitä tietoja käyttäen trainerin tietokohteen muokkausnäkymän näyttävän sivun tekeminen
		 */

		public static function edit($id) {

			$teams = Team::all();
			$attributes = User::find($id);

			View::make('user/edit.html', array('teams' => $teams, 'attributes' => $attributes));

		}

		/**
		 * metodi login on vastuussa sisäänkirjautumissivun tekemisestä
		 */

		public static function login(){
		      View::make('user/login.html');

 		}

		/**
		 * metodi handle_login on vastuussa sisäänkirjautumissivun lomakkeen tietojen käsittelystä ja niiden oikeellisuuden varmistamisesta ja näin
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
		 * metodi logout on vastuussa uloskirjautumisen toteuttamisessa sekä uloskirjautumisen yhteydessä uloskirjautuvan käyttäjän session päättämisessä
		 */

		public static function logout(){
			$_SESSION['user'] = null;
			Redirect::to('/', array('message' => 'You have been signed out!'));
		}

		/**
		 * metodi create on vastuussa uuden käyttäjän rekisteröitymistä varten tarvittavan lomakesivun tekemisestä
		 */

		public static function create() {

			$teams = Team::all();
			View::make('user/new.html', array('teams' => $teams));

		}

		/**
		 * metodi store on vastuussa rekisteröityvän käyttäjän tietojen vastaanottamisessa ja niiden oikeellisuuden tarkistamisessa sekä näiden tietojen
		 * edelleen välittämisestä trainer-tietokohteen tietokantaan tallentavalle user.php luokalle
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
		 * metodi update ottaa vastaan parametrina trainer-tietokohteen tunnisteen jonka tietoja halutaan muuttaa, sekä on vastuussa näiden tietojen
		 * oikeellisuuden tarkistamisesta ja oikeelliseksi varmistamiensa tietojen edelleen välittämisestä trainer-tietokohteen tietoja muuttavalle user.php luokalle
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
		 * metodi destroy ottaa vastaan parametrina trainer-tietokohteen tunnisteen joka tietokannasta halutaan poistaa sekä välittää tämän tiedon
		 * edelleen sen tietokannasta poistavalle users.php luokalle
		 */

		public static function destroy($id) {

			$user = new User(array('id' => $id));

			$user->destroy();

			Redirect::to('/', array('message' => 'Account successfully deleted!'));

		}
 


	}
