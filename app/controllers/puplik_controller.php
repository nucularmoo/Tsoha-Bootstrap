<?php
	
	/**
	 * Luokka PublicController vastaa kirjautumattoman käyttäjän näkymien luomisesta
	 */

	class PublicController extends BaseController {

		/**
		 * metodi index on vastuussa julkisesti nähtävissä olevan pokemon- sekä base_pokemon-tietokohteiden yhdisteen
		 * listaussivun tekemisestä
		 */

		public static function index() {
			
			$mons = Supermon:: all();
			View::Make('puplik/index.html', array('mons' => $mons));

		}

	}
