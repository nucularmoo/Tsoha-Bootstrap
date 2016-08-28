<?php

	class User extends BaseModel {

		public $id, $name, $password, $team_id;

		public function __construct($attributes) {
			parent::__construct($attributes);
		}

		public static function find($id) {

			$query = DB::connection()->prepare('SELECT * FROM trainer WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if($row) {

				$user = new User(array(
					'id' => $row['id'],
					'name' => $row['name'],
					'password' => $row['password'],
					'team_id' => $row['team_id']
				));

				return $user;

			} else {
				return null;

			}
		}

		public static function authenticate($name, $password) {

			$query = DB::connection()->prepare('SELECT * FROM trainer WHERE name = :name AND password = :password limit 1');
			$query->execute(array('name' => $name, 'password' => $password));
			$row = $query->fetch();

			if($row) {

				$user = new User(array(
					'id' => $row['id'],
					'name' => $row['name'],
					'password' => $row['password'],
					'team_id' => $row['team_id']
				));

				return $user;

			} else {
				return null;
			}

		}

	}
