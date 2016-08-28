<?php

	class Basemon extends BaseModel {

		public $id, $name;

		public function __construct($attributes) {
		
			parent::__construct($attributes);
		}


		public static function all() {

			$query = DB::connection()->prepare('SELECT * FROM base_pokemon');
			$query->execute();
			$rows = $query->fetchAll();
			$basemons = array();

			foreach($rows as $row) {

				$basemons[] = new Basemon(array(

					'id' => $row['id'],
					'name' => $row['name']
				));
			}

			return $basemons;
		}

		public static function find_by_id($id) {

			$query = DB::connection()->prepare('SELECT * FROM base_pokemon WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if($row) {

				$basemon = new Basemon(array(

					'id' => $row['id'],
					'name' => $row['name']
				));

				return $basemon;

			}

			return null;

		}

		public static function find_by_name($name) {

			$query = DB::connection()->prepare('SELECT * FROM base_pokemon WHERE name = :name LIMIT 1');
			$query->execute(array('name' => $name));
			$rows = $query->fetch();

			if($row) {

				$basemon = new Basemon(array(

					'id' => $row['id'],
					'name' => $row['name']
				));

				return $basemon;

			}

			return null;

		}

	}
