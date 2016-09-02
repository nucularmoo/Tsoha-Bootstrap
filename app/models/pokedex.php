<?php

	/**
	 * Luokka PokeDex toimii välikappaleena tietokannan Pokedex-liitostaulun ja siitä kiinnostuneiden kontrollereiden vällillä
	 * välittäen tietoa tietokannasta kontrollereille sekä kontrollereista tietokantaan
	 */

	class Pokedex extends BaseModel {

		public $trainer_id, $pokemon_id;

		public function __construct($attributes) {

			parent::__construct($attributes);
	
		}

		/**
		 * Metodi save tallentaa liitoksen tietyn Trainerin ja tietyn Pokemonin välille
		 */

		public function save() 

			$query = DB::connection()->prepare('INSERT INTO POKEDEX (trainer_id, pokemon_id) VALUES (:trainer_id, :pokemon_id)');

			$query->execute(array('trainer_id' => $this->trainer_id, 'pokemon_id' => $this->pokemon_id));

			$row = $query->fetch();

		}
	
		/**
		 * Metodi destroy poistaa liitoksen tietyn Trainerin ja tietyn Pokemonin väliltä
		 */		

		public function destroy() {

			$query = DB::connection()->prepare('DELETE FROM POKEDEX WHERE trainer_id = :trainer_id AND pokemon_id = :pokemon_id');

			$query->execute(array('trainer_id' => $this->trainer_id, 'pokemon_id' => $this->pokemon_id));

		}

		/**
		 * Metodi destroy_all_by_trainer_keep_public_dex poistaa kaikki liitokset tietyn trainerin ja kaikkien
		 * Pokemonien välillä, joihin trainer on ollut liitettynä
		 */

		public function destroy_all_by_trainer_keep_public_dex() {

			$query = DB::connection()->prepare('DELETE FROM POKEDEX WHERE trainer_id = :trainer_id');

			$query->execute(array('trainer_id' => $this->trainer_id));

		}

		/**
		 * Metodi destroy_all_by_trainer poistaa kaikki liitokset tietyn trainerin ja kaikkien Pokemonien
		 * välillä joihin trainer on ollut liitettynä, ja lopuksi poistaa kaikkien näiden Pokemon-tietokohteiden
		 * tietosisällöt
		 */

		public function destroy_all_by_trainer() {

			$query = DB::connection()->prepare('DELETE FROM POKEDEX WHERE TRAINER_ID = :trainer_id');

			$query->execute(array('trainer_id' => $this->trainer_id));

			$querytwo = DB::connection()->prepare('DELETE FROM POKEMON WHERE POKEMON.ID NOT IN(SELECT POKEDEX.POKEMON_ID FROM POKEDEX)');

			$querytwo->execute();

		}

	}
