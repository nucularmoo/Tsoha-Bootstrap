<?php

	class User extends BaseModel {

		public $id, $name, $password, $team_id;

		public function __construct($attributes) {
			parent::__construct($attributes);
			$this->validators = array('validate_name', 'validate_password');
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
		
		public function save() {

			$query = DB::connection()->prepare('INSERT INTO Trainer (name, password, team_id) VALUES (:name, :password, :team_id) RETURNING id');

			$query->execute(array('name' => $this->name, 'password' => $this->password, 'team_id' => $this->team_id));

			$row = $query->fetch();

			$this->id = $row['id'];
		}


		public function validate_name() {

			$errors = array();

			if($this->name == '' || $this->name == null) {

				$errors[] = 'Field "name" cannot be empty.';

			}

			if(strlen($this->name) < 4) {

				$errors[] = 'Field "name" must be at least four characters.';

			}

			return $errors;

		}

		public function validate_password() {

			$errors = array();

			if($this->password == '' || $this->password == null) {

				$errors[] = 'Field "password" cannot be empty.';
			}

			if(strlen($this->password) < 5) {

				$errors[] = 'Field "password" must be at least five characters.';

			}

			return $errors;

		}

	}
