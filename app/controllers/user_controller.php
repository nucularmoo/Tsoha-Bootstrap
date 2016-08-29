<?php
	class UserController extends BaseController{
		public static function login(){
		      View::make('user/login.html');
 		}

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

		public static function logout(){
			$_SESSION['user'] = null;
			Redirect::to('/', array('message' => 'You have been signed out!'));
		}

		public static function create() {

			$teams = Team::all();
			View::make('user/new.html', array('teams' => $teams));

		}

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


	}
