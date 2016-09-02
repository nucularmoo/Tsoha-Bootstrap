<?php
	/**
	 * Luokka Mon toimii välikappaleena tietokannan Pokemon-tietokohteiden sekä niistä kiinnostuneiden
	 * kontrollereiden välillä välittäen tietokannasta tietoa kontrollereille sekä kontrollereista tietokantaan
	 */

	class Mon extends BaseModel {

		
		public $id, $basemon_id, $overall_appraisal, $stats_appraisal, $caught_location, $cp;

		
		public function __construct($attributes) {
			parent::__construct($attributes);
			$this->validators = array('validate_location', 'validate_cp');
		}
	
		/**
		 * Metodi all hakee kaikki Pokemon-tietokohteiden tietosisällöt tietokannasta
		 */

		public static function all(){
			$query = DB::connection()->prepare('SELECT * FROM pokemon');
	
			$query->execute();
	
			$rows = $query->fetchAll();
	
			$mons = array();
	
			
			foreach($rows as $row) {
	
				$mons[] = new Mon(array(
					'id' => $row['id'],
					'basemon_id' => $row['basemon_id'],
					'overall_appraisal' => $row['overall_appraisal'],
					'stats_appraisal' => $row['stats_appraisal'],
					'caught_location' => $row['caught_location'],
					'cp' => $row['cp']
				));
			}
	
			return $mons;
		}

		/**
		 * Metodi find hakee sille parametrina annetun tunnisteen perusteella tietokannasta tunnistetta
		 * vastaavan Pokemon-tietokohteen tietosisällön
		 */
	
		public static function find($id) {
	
			$query = DB::connection()->prepare('SELECT * FROM pokemon WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));
			$row = $query->fetch();
	
			if($row) {
	
				$mon = new Mon(array(
				'id' => $row['id'],
				'basemon_id' => $row['basemon_id'],
       	                         'overall_appraisal' => $row['overall_appraisal'],
       	                         'stats_appraisal' => $row['stats_appraisal'],
       	                         'caught_location' => $row['caught_location'],
       	                         'cp' => $row['cp']
	
				));
	
				return $mon;

			}
					
		}

		/**
		 * Metodi save tallentaa tietokantaan uuden Pokemon-tietokohteen tietosisällön
		 */
	
		public function save() {
	
			$query = DB::connection()->prepare('INSERT INTO Pokemon (basemon_id, overall_appraisal, stats_appraisal, caught_location, cp) VALUES (:basemon_id, :overall_appraisal, :stats_appraisal, :caught_location, :cp) RETURNING id');
	
			$query->execute(array('basemon_id' => $this->basemon_id, 'overall_appraisal' => $this->overall_appraisal, 'stats_appraisal' => $this->stats_appraisal, 'caught_location' => $this->caught_location, 'cp' => $this->cp));
	
			$row = $query->fetch();
	
			$this->id = $row['id'];
		}

		/**
		 * Metodi update päivittää tietokannassa Pokemon-tietokohteen tietosisällön
		 */
	
		public function update() {
	
			$query = DB::connection()->prepare('UPDATE Pokemon SET basemon_id=:basemon_id, overall_appraisal=:overall_appraisal, stats_appraisal=:stats_appraisal, caught_location=:caught_location, cp=:cp WHERE id = :id');
	
			$query->execute(array('id' => $this->id, 'basemon_id' => $this->basemon_id, 'overall_appraisal' => $this->overall_appraisal, 'stats_appraisal' => $this->stats_appraisal, 'caught_location' => $this->caught_location, 'cp' => $this->cp));
	
		}

		/**
		 * Metodi destroy poistaa tietokannasta Pokemon-tietokohteen tietosisällön
		 */
	
		public function destroy() {
	
			$query = DB::connection()->prepare('DELETE FROM Pokemon WHERE id=:id');
	
			$query->execute(array('id' => $this->id));
	
		}		 


		/**
		 * Metodi validate_location validoi tietokantaan Pokemon-tietokohteen caught_location-tietueeseen
		 * lisättävissä tai muutettavissa olevan caught_location-tietueen tietosisällön ennen sen
		 * lisäämistä tai muuttamista
		 */
		
		public function validate_location() {
		
			$errors = array();
		
			if($this->caught_location == '' || $this->caught_location == null) {
	
				$errors[] = 'Please enter a location';
		
			}

			if(strlen($this->caught_location) > 400) {

				$errors[] = 'Description of caught location cannot exceed 400 characters';

			}
	
			return $errors;
		}

		/**
		 * Metodi validate_cp validoi tietokantaan Pokemon-tietokohteen cp-tietueeseen lisättävissä tai
		 * muutettavissa olevan cp-tietueen tietosisällön ennen sen lisäämistä tai muuttamista
		 */
	
		public function validate_cp() {
	
			$errors = array();
	
			if($this->cp == '' || $this->cp == null) {
	
				$errors [] = 'Please enter a CP value';
	
				return $errors;
	
			}
	
			if(!is_numeric($this->cp)) {
	
				$errors[] = 'Please enter a valid numeric CP value';
	
				return $errors;
			}
	
			if(intval($this->cp) < 10 || intval($this->cp) > 9000) {
	
				$errors[] = 'Please enter a valid numeric CP value between digits 10 and 9000';
	
				return $errors;
	
			}
	
			return $errors;
	
		}
	}
?>
