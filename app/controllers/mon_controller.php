<?php
	
	/**
	 * Luokka MonController vastaa kirjautuneen käyttäjän näkymien luomisesta sekä välittää tallennettavat,
	 * muutettavat tai poistettavat tiedot Pokemon-tietokohteisiin liittyen luokalle mon.php.
	 */	

	class MonController extends BaseController {


		/**
		 * Metodi index hakee kaikki kirjautuneen käyttäjän pokemon-tietokohteet ja luo niistä käyttäjäkohtaisen
		 * pokedex-näkymän
		 */

		public static function index() {
			
			$mons = Supermon::all();

			View::make('mon/index.html', array('mons' => $mons));
		}

		/**
		 * Metodi dexindex ottaa parametrina Trainer-tietokohteen tunnisteen ja hakee kaikki Trainerin tunnisteeseen
		 * liitostaulussa liitetyt Pokemonit, jonka jälkeen se luo käyttäjälle asianmukaisen näkymän.
		 */

		public static function dexindex($trainer_id) {

			$mons = Supermon::all_by_trainerid($trainer_id);
			$trainer = User::find($trainer_id);
			View::make('mon/index.html', array('mons' => $mons, 'trainer' => $trainer));
		}

		/**
		 * Metodi show ottaa parametrina Pokemon-tietokohteen tunnisteen sekä Trainer-tietokohteen tunnisteen,
		 * varmentaa että Pokemon kuuluu (on liitostaulussa Pokedex liitetty) kyseiselle Trainerille, jonka
		 * jälkeen se luo käyttäjälle asianmukaiselle näkymän
		 */

		public static function show($id, $trainer_id) {

			$trainer = User::find($trainer_id);
			$mon = Supermon::find_by_trainerid($id, $trainer_id);

			if ($mon == null) {

				$mons = Supermon::all_by_trainerid($trainer_id);
				$trainer = User::find($trainer_id);
				View::make('mon/index.html', array('mons' => $mons, 'trainer' => $trainer));

			} else {
			View::make('mon/view.html', array('mon' => $mon, 'trainer'=> $trainer));

			}
		}

		/**
		 * Metodi edit ottaa parametrina Pokemon-tietokohteen tunnisteen sekä Trainer-tietokohteen tunnisteen,
		 * varmentaa että Pokemon kuuluu (on liitostaulussa Pokedex liitetty) kyseiselle Trainerille, jonka
		 * jälkeen se luo käyttäjälle asianmukaisen näkymän
		 */

		   public static function edit($id, $trainer_id) {

			$basemons = Basemon::all();
                        $mon = Supermon::find_by_trainerid($id, $trainer_id);
			$trainer = User::find($trainer_id);
			
			if ($mon == null) {

				$mons = Supermon::all_by_trainerid($trainer_id);
				$trainer = User::find($trainer_id);
				View::make('mon/index.html', array('mons' => $mons, 'trainer' => $trainer));

			} else {

                        View::make('mon/edit.html', array('mon' => $mon, 'basemons' => $basemons, 'trainer' => $trainer));
			}
                }
		
		/**
		 * Metodi create hakee kaikki base_pokemon tietokohteet sekä välittää ne lomakesivulle 
		 *jolla uusi Pokémon-entry lisätään tietokantaan
		 */

		public static function create() {

			$basemons = Basemon::all();

                        View::make('mon/new.html', array('basemons' => $basemons));
                }

		/**
		 * Metodi store on vastuussa uuden pokemon-tietokohteen tietosisällön tallennuksen validoinnin varmistamisesta
		 * sekä tietokohteen tietosisällön välityksestä tiedot tallenvataan mon.php-luokkaan sekä käyttäjän
		 * uudelleenohjaamisesta asianmukaiselle sivulle
		 */


		public static function store() {

			$basemons = Basemon::all();

			$params = $_POST;

			$trainer_id = $params['trainer_id'];

			$basemon_id = $params['basemon_id'];
			$overall_appraisal = $params['overall_appraisal'];
			$stats_appraisal = $params['stats_appraisal'];

			$attributes = array(
				'basemon_id' => $basemon_id,
				'overall_appraisal' => $overall_appraisal,
				'stats_appraisal' => $stats_appraisal,
				'caught_location' => $params['caught_location'],
				'cp' => $params['cp']
			); 

			$mon = new Mon($attributes);
			

			$errors = $mon->errors();

			if(count($errors) == 0) {

				$mon->save();
				
				$tributes = array(
					'trainer_id' => $trainer_id,
					'pokemon_id' => $mon->id
				);
				$pokedex = new Pokedex($tributes);
				$pokedex->save();
		

			Redirect::to('/mon/' . $mon->id . '/' . $trainer_id, array('message' => 'Added!')); 

			} else {
	
			View::make('mon/new.html', array('errors' => $errors, 'basemons' => $basemons, 'attributes' => $attributes));

			}

		}

		/**
		 * Metodi update on vastuussa jo olemassaolevan pokemon-tietokohteen tietosisällön päivityksen validoinnin varmistamisesta
		 * sekä päivitetyn Pokemon-tietokohteen tietosisällön välityksestä tiedot päivittävään mon.php-luokkaan
		 */

		public static function update($id) {

			$basemons = Basemon::all();
			$params = $_POST;

			$basemon_id = $params['basemon_id'];
			$overall_appraisal = $params['overall_appraisal'];
			$stats_appraisal = $params['stats_appraisal'];

			$attributes = array(
				'id' => $id,
				'basemon_id' => $basemon_id,
				'overall_appraisal' => $overall_appraisal,
				'stats_appraisal' => $stats_appraisal,
				'caught_location' => $params['caught_location'],
				'cp' => $params['cp']
			);

			$mon = new Mon($attributes);
			$errors = $mon->errors();

			if(count($errors) > 0) {
				View::make('mon/edit.html', array('errors' => $errors, 'basemons' => $basemons, 'mon' => $attributes));

			} else {

				$mon->update();

				Redirect::to('/mon/' . $mon->id, array('message' => 'Edit successful!'));
			}

		}

		/**
		 * Metodi destroy_mon ottaa vastaan pokemon-tietokohteen tunnisteen sekä trainer-tietokohteen tunnisteen, 
	   	 * ja on vastuussa kyseisen trainerin tunnisteeseen liitetyn pokedex-tietosisällön poistokäskyn välittämisestä
		 * edelleen, jonka jälkeen metodi välittää käskyn poistaa kyseisen pokemon-tietokohteen tietosisältö tietokannasta
		 */

		public static function destroy_mon($id, $trainer_id) {

			$pokedex = new Pokedex(array('trainer_id' => $trainer_id, 'pokemon_id' => $id));

                        $pokedex->destroy();


			$mon = new Mon(array('id' => $id));

			$mon->destroy();

			Redirect::to('/pokedex/' . $trainer_id, array('message' => 'Pokémon successfully deleted!'));
		}

		/**
		 * Metodi destroy_dex ottaa vastaan pokemon-tietokohteen tunnisteen sekä trainer-tietokohteen tunnisteen,
		 * ja on vastuussa kyseisen trainerin tunnisteeseen liitetyn pokedex-tietokohteen tietosisällön poistokäskyn
		 * välittämisestä edelleen
		 */

		public static function destroy_dex($id, $trainer_id) {

			$pokedex = new Pokedex(array('trainer_id' => $trainer_id, 'pokemon_id' => $id));

			$pokedex->destroy();

			Redirect::to('/pokedex/' . $trainer_id, array('message' => 'Delete successful!'));

		}
	}
