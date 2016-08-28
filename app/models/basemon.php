<?php

	class Basemon extends BaseModel {

		public $dexnumber, $name;

		public function __construct($attributes) {
		
			parent::__construct($attributes);
		}


		public static function all() {

			$query = DB::connection()->prepare('SELECT * FROM base_pokemon ORDER BY name');
			$query->execute();
			$rows = $query->fetchAll();
			$basemons = array();

			foreach($rows as $row) {

				$basemons[] = new Basemon(array(

					'dexnumber' => $row['dexnumber'],
					'name' => $row['name']
				));
			}

			return $basemons;
		}

		public static function find_by_id($dexnumber) {

			$query = DB::connection()->prepare('SELECT * FROM base_pokemon WHERE dexnumber = :dexnumber LIMIT 1');
			$query->execute(array('dexnumber' => $dexnumber));
			$row = $query->fetch();

			if($row) {

				$basemon = new Basemon(array(

					'dexnumber' => $row['dexnumber'],
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

					'dexnumber' => $row['dexnumber'],
					'name' => $row['name']
				));

				return $basemon;

			}

			return null;

		}

	}
