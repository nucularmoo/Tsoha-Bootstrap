<?php

	/**
	 * Luokka Team on vastuussa team-tietokohteen tietojen tietokantakyselyistä
	 */

	class Team extends BaseModel {

		public $id, $name;

		public function __construct($attributes) {

			parent::__construct($attributes);

		}

		/**
		 * Metodi all hakee kaikki Team-tietokohteen tietosisällöt ja palauttaa ne
		 */

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
			
