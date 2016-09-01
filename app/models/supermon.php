<?php

	/**
	 * Luokka Supermon kuvaa liitoskyselyillä tuotettua yhdistettä tietokohteista base_pokemon ja pokemon sekä näiden tietojen välittämisestä edelleen
	 * asianomaisille kontrollereille
	 */

	class Supermon extends BaseModel {

		public $id, $trainer_id, $name, $basemon_id, $overall_appraisal, $stats_appraisal, $caught_location, $cp;

		public function __construct($attributes) {
		
			parent::__construct($attributes);
		}

		/**
		 * Metodi all tekee tietokantaan INNER JOIN-kyselyn yhdistäen kaikki Pokemon-tietokohteet oikeisiin base_pokemon tietokohteisiin ja palauttaen listan
		 * kaikista Pokemon-tietokohteista näiden asianmukaisilla base_pokemon tietokohteiden tiedoilla järjestettynä base_pokemon tietokohteen dexnumeron mukaan
		 */

		public static function all() {

			$query = DB::connection()->prepare('SELECT* FROM POKEMON INNER JOIN BASE_POKEMON ON POKEMON.BASEMON_ID = BASE_POKEMON.DEXNUMBER ORDER BY POKEMON.BASEMON_ID');
			$query->execute();
			$rows = $query->fetchAll();
			$supermons = array();

			foreach($rows as $row) {

				$supermons[] = new Supermon(array(

					'id' => $row['id'],
					'name' => $row['name'],
					'basemon_id' => $row['basemon_id'],
					'overall_appraisal' => $row['overall_appraisal'],
					'stats_appraisal' => $row['stats_appraisal'],
					'caught_location' => $row['caught_location'],
					'cp' => $row['cp']

				));
			}

			return $supermons;
			
		}

		public static function all_by_trainerid($trainer_id) {

			$query = DB::connection()->prepare('SELECT * FROM POKEDEX INNER JOIN POKEMON ON POKEDEX.POKEMON_ID = POKEMON.ID JOIN BASE_POKEMON ON BASE_POKEMON.DEXNUMBER = POKEMON.BASEMON_ID WHERE POKEDEX.TRAINER_ID = :trainer_id ORDER BY POKEMON.BASEMON_ID');
			$query->execute(array('trainer_id' => $trainer_id));
			$rows = $query->fetchAll();
			$supermons = array();

			foreach($rows as $row) {

				$supermons[] = new Supermon(array(

				'id' => $row['id'],
				'trainer_id' => $row['trainer_id'],
				'name' => $row['name'],
                                'basemon_id' => $row['basemon_id'],
				'overall_appraisal' => $row['overall_appraisal'],
                                'stats_appraisal' => $row['stats_appraisal'],
                                'caught_location' => $row['caught_location'],
                                'cp' => $row['cp']

                                ));
                        }

                        return $supermons;

                }


		/**
		 * Metodi find hakee ja palauttaa sille parametrina annetun Pokemonin sekä siihen liitetyn base_pokemonin tiedot ja palauttaa ne Supermon-oliona
		 * molempien tietokohteiden tiedoilla varustettuna tai null jos tietokohdetta ei tietokannasta löydy
		 */

		public static function find($id) {

			$query = DB::connection()->prepare('SELECT * FROM POKEMON INNER JOIN BASE_POKEMON ON POKEMON.BASEMON_ID = BASE_POKEMON.DEXNUMBER WHERE POKEMON.ID = :id LIMIT 1');
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if($row) {

				$supermon = new Supermon(array(

					'id' => $row['id'],
					'name' => $row['name'],
					'basemon_id' => $row['basemon_id'],
					'overall_appraisal' => $row['overall_appraisal'],
					'stats_appraisal' => $row['stats_appraisal'],
					'caught_location' => $row['caught_location'],
					'cp' => $row['cp']
				));

				return $supermon;

			}

			return null;

		}

		

	}

			
