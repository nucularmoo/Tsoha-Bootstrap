<?php
	
	/**
	 * Luokka MonController vastaa kirjautuneen käyttäjän näkymien luomisesta sekä välittää tallennettavat, muutettavat tai poistettavat tiedot
	 * Pokemon-tietokohteisiin liittyen luokalle mon.php.
	 */	

	class MonController extends BaseController {


		/**
		 * metodi index hakee kaikki kirjautuneen käyttäjän pokemon-tietokohteet ja luo niistä käyttäjäkohtaisen
		 * pokedex-näkymän
		 */

		public static function index() {
			
			$mons = Supermon::all();

			View::make('mon/index.html', array('mons' => $mons));
		}

		/**
		 * metodi show hakee sille annetun parametrin perusteella pokemon- ja base_pokemon-tietokohteen yhdistetyn ilmentymän 
		 * ja luo sen tietoja käyttäen yksittäisen näkymän näiden tietokohteiden liitokselle
		 */

		public static function show($id) {

			$mon = Supermon::find($id);
			View::make('mon/view.html', array('mon' => $mon));
		}

		/**
		 * metodi edit hakee kaikki base_pokemon-tietokohteet sekä sille annetun parametrin perusteella pokemon- ja base_pokemon-tietokohteen
		 * yhdistetyn ilmentymän sekä luo pokemon-tietokohteen muokkausnäkymän näiden tietoja käyttäen
		 */

		   public static function edit($id) {

			$basemons = Basemon::all();
                        $mon = Supermon::find($id);
                        View::make('mon/edit.html', array('mon' => $mon, 'basemons' => $basemons));
                }
		
		/**
		 * metodi create hakee kaikki base_pokemon tietokohteet sekä välittää ne lomakesivulle jolla uusi Pokémon-entry lisätään tietokantaan
		 */

		public static function create() {

			$basemons = Basemon::all();

                        View::make('mon/new.html', array('basemons' => $basemons));
                }

		/**
		 * metodi store on vastuussa uuden pokemon-tietokohteen tallenukseen liittyen tiedon oikeellisuuden varmoistamisesta sekä
		 * tietokohteen tietojen välityksestä tiedot tallenvataan mon.php-luokkaan, ja onnistuneen lisäyksen jälkeisen sivun lataamisesta
		 */


		public static function store() {

			$basemons = Basemon::all();

			$params = $_POST;

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
		

			Redirect::to('/mon/' . $mon->id, array('message' => 'Added!')); 

			} else {
	
			View::make('mon/new.html', array('errors' => $errors, 'basemons' => $basemons, 'attributes' => $attributes));

			}

		}

		/**
		 * metodi update on vastuussa jo olemassaolevan pokemon-tietokohteen tietojen päiivityksen oikeellisuuden varmistamisesta sekä
		 * päivitettyjen tietokohteen tietojen välityksestä tiedot päivittämään mon.php-luokkaan
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
		 * metodi destroy on vastuussa sille parametrina annetun pokemon-tietokohteen tunnisteen tiedon välittämisestä 
		 * tietokohteen poistavalle mon-php luokalle
		 */

		public static function destroy($id) {

			$mon = new Mon(array('id' => $id));

			$mon->destroy();

			Redirect::to('/mon', array('message' => 'Pokémon successfully deleted!'));
		}
	}
