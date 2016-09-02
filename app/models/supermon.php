<?php

	/**
	 * Luokka Supermon kuvaa liitoskyselyillä tuotettua yhdistettä tietokohteista base_pokemon ja pokemon ja toimii
	 * välikappaleena näistä yhdisteistä kiinnostuneiden kontrollerien ja tietokannan välillä
	 */

	class Supermon extends BaseModel {

		public $id, $trainer_id, $name, $basemon_id, $overall_appraisal, $stats_appraisal, $caught_location, $cp;

		public function __construct($attributes) {
		
			parent::__construct($attributes);
		}

		/**
		 * Metodi all tekee tietokantaan INNER JOIN-kyselyn yhdistäen kaikki Pokemon-tietokohteiden tietosisällöt
		 * niihin liitettyihin base_pokemon-tietokohteiden tietosisältöihin ja palauttaen listan kaikista 
		 * Pokemon-tietokohteista näiden asianmukaisilla base_pokemon-tietokohteista liitetyillä tiedoilla 
		 * järjestettynä base_pokemon tietokohteen dexnumber-tietueen mukaisesti
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

		/**
		 * Metodi all_by_trainerid tekee saman kuin metodi all, mutta rajaa palautettavan listan tietosisällön 
		 * pokedex-liitostaulun trainer_id:tä käyttäen, eli palauttaa tietylle trainerille kuuluvat 
		 * Pokemon-tietokohteiden tietosisällöt näiden asianmukaisilla base_pokemon-tietokohteista liitetyillä 
		 * tiedoilla järjestettynä base_pokemon-tietokohteen dexnumber-tietueen mukaisesti
		 */

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
		 * Metodi find_by_trainerid hakee Pokedex-taulusta parametrina annetun trainer_id:hen liitetyn parametrina 
		 * annetun pokemonin id:n ja palauttaa liitoskyselyllä tuotetun yhdisteen Pokemonin tunnisteella haetun 
		 * Pokemon-tietokohteen tietosisällöstä sekä siihen liitetyn base_pokemon-tietokohteen tietosisällöstä tai 
		 * null jos tietokohteen tietosisältöä ei tietokannasta löydy
		 */

		public static function find_by_trainerid($id, $trainer_id) {

			$query = DB::connection()->prepare('SELECT * FROM POKEDEX INNER JOIN POKEMON ON POKEDEX.POKEMON_ID = POKEMON.ID JOIN BASE_POKEMON ON BASE_POKEMON.DEXNUMBER = POKEMON.BASEMON_ID WHERE POKEDEX.TRAINER_ID = :trainer_id AND POKEMON.ID = :id');
			$query->execute(array('trainer_id' => $trainer_id, 'id' => $id));
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


		/**
		 * Metodi find hakee ja palauttaa sille parametrina annetun Pokemon-tietokohteen tunnisteen omaavan 
		 * Pokemon-tietokohteen tietosisällön sekä siihen liitetyn base_pokemon-tietokohteen tietosisällön 
		 * yhdisteen tai null jos tietokohteen tietosisältöä ei tietokannasta löydy
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

			
