<?php

	/**
	 * Luokka Basemon on vastuussa base_pokemon-tietokohteen tietojen tietokantakyselyistä sekä näiden tietojen välittämisesttä
	 * edelleen asianomaisille kontrollereille
	 */

	class Basemon extends BaseModel {

		public $dexnumber, $name;

		public function __construct($attributes) {
		
			parent::__construct($attributes);
		}

		/**
		 * Metodi all on vastuussa kaikkien base_pokemonien hakemisesta tietokannassa aakkosjärjestyksessä sekä näiden tietojen edelleen välittäminen
		 * asianomaisille kontrollereille
		 */


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

		/**
		 * Metodi find_by_id ottaa parametrina vastaan base_pokemonin tunnisteen ja löytäessään tämän tietokannasta palauttaa sen tiedot asianomaiselle
		 * kontrollerille tai null, jos tietokohdetta ei löydy
		 */

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

		/**
		 * Metodi find_by_name ottaa parametrina vastaan base_pokemonin nimen ja löytäessään tämän tietokannasta palauttaa sen tiedot asianomaiselle
		 * kontrollerille tai null, jos tietokohdetta ei löydy
		 */

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
