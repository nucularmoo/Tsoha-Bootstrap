<?php

	/**
	 * Luokka User toimii välikappaleena tietokannan trainer-tietokohteiden sekä niistä kiinnostuneiden
	 * kontrollereiden välillä välittäen tietoa tietokannasta kontrollereille sekä kontrollereista tietokantaan
	 */

	class User extends BaseModel {

		public $id, $name, $password, $team_id;

		public function __construct($attributes) {
			parent::__construct($attributes);
			$this->validators = array('validate_name', 'validate_password');
		}

		/**
		 * Metodi find hakee sille parametrina annetun tunnisteen perusteella tietokannasta tunnistetta
		 * vastaavan trainer-tietokohteen tiedot sekä välittää ne asianomaiselle kontrollerille
		 */

		public static function find($id) {

			$query = DB::connection()->prepare('SELECT * FROM trainer WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if($row) {

				$user = new User(array(
					'id' => $row['id'],
					'name' => $row['name'],
					'password' => $row['password'],
					'team_id' => $row['team_id']
				));

				return $user;

			} else {
				return null;

			}
		}

		/**
		 * Metodi authenticate ottaa parametrina trainer-tietokohteen nimen ja salasanan ja hakee tietokannasta
		 * niitä vastaavaa tietokohdetta, palauttaen sen tiedot asianomaiselle kontrollerille tietokohteen
		 * löytyessä ja muissa tilanteissa palauttaa null
		 */

		public static function authenticate($name, $password) {

			$query = DB::connection()->prepare('SELECT * FROM trainer WHERE name = :name AND password = :password limit 1');
			$query->execute(array('name' => $name, 'password' => $password));
			$row = $query->fetch();

			if($row) {

				$user = new User(array(
					'id' => $row['id'],
					'name' => $row['name'],
					'password' => $row['password'],
					'team_id' => $row['team_id']
				));

				return $user;

			} else {
				return null;
			}

		}

		/**
		 * Metodi save tallentaa tietokantaan asianomaiselta kontrollerilta saaman tiedon mukaan
		 * uuden trainer-tietokohteen tietoineen
		 */
		
		public function save() {

			$query = DB::connection()->prepare('INSERT INTO Trainer (name, password, team_id) VALUES (:name, :password, :team_id) RETURNING id');

			$query->execute(array('name' => $this->name, 'password' => $this->password, 'team_id' => $this->team_id));

			$row = $query->fetch();

			$this->id = $row['id'];
		}

		/**
		 * Metodi update päivittää tietokanassa trainer-tietokohteen tiedot sille annettujen tietojen mukaan
		 */

		public function update() {
			
			$query = DB::connection()->prepare('UPDATE Trainer SET name=:name, password=:password, team_id=:team_id WHERE id = :id');

			$query->execute(array('id' => $this->id, 'name' => $this->name, 'password' => $this->password, 'team_id' => $this->team_id));

		}

		/**
		 * Metodi destroy poistaa tietokannasta trainer-tietokohteen tiedot sille annettujen tietojen mukaan
		 */

		public function destroy() {

			$query = DB::connection()->prepare('DELETE FROM Trainer WHERE id=:id');

			$query->execute(array('id' => $this->id));

		}

		/**
		 * Metodi validate_name validoi tietokantaan trainer-tietokohteen name-tietueeseen
		 * lisättävissä tai muutettavissa olevan nimen oikeellisuuden ennen lisäyksen tai
		 * muutoksen tapahtumista
		 */

		public function validate_name() {

			$errors = array();

			if($this->name == '' || $this->name == null) {

				$errors[] = 'Field "name" cannot be empty.';

			}

			if(strlen($this->name) < 4) {

				$errors[] = 'Field "name" must be at least four characters.';

			}

			return $errors;

		}

		/**
		 * Metodi validate_password validoi trainer-tietokohteen password-tietueeseen
		 * lisättävissä tai muutettavissa olevan tiedon oikean muodon ennen sen
		 * lisäämistä tai muuttamista
		 */

		public function validate_password() {

			$errors = array();

			if($this->password == '' || $this->password == null) {

				$errors[] = 'Field "password" cannot be empty.';
			}

			if(strlen($this->password) < 5) {

				$errors[] = 'Field "password" must be at least five characters.';

			}

			return $errors;

		}

	}
