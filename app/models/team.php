<?php

	/**
	 * Luokka Team on vastuussa team-tietokohteen tietojen tietokantakyselyistä
	 */

	class Team extends BaseModel {

		public $id, $name;

		public function __construct($attributes) {

			parent::__construct($attributes);

		}

		public static function all() {

			$query = DB::connection()->prepare('SELECT * FROM TEAM');
			$query->execute();
			$rows = $query->fetchAll();
			$teams = array();

			foreach($rows as $row) {

				$teams[] = new Team( array(

					'id' => $row['id'],
					'name' => $row['name']
				));
			}

			return $teams;

		}

	}
			
