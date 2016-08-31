<?php
	/**
	 * Luokka Mon tekee tietokantakyselyt ja hallinnoi tiedon välittämistä asianomaisten kontrollerien sekä tietokannan Pokemon-tietokohteiden välillä
	 */

	class Mon extends BaseModel {

		
		public $id, $basemon_id, $overall_appraisal, $stats_appraisal, $caught_location, $cp;

		
		public function __construct($attributes) {
			parent::__construct($attributes);
			$this->validators = array('validate_o_appraisal', 'validate_s_appraisal', 'validate_location', 'validate_cp');
		}
	
		/**
		 * Metodi all hakee kaikki Pokemon-tietokohteet tietokannasta sekä välittää niiden tiedot edelleen asianomaisille kontrollereille
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
		 * Metodi find ottaa vastaan Pokemon-tietokohteen tunnisteen parametrina sekä hakee tietokannasta 
		 * kyseisellä tunnisteella varustetun Pokemon-tietokohteen tiedot ja välittää ne edelleen asianomaiselle
		 * kontrollerille
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
		 * Metodi save ottaa vastaan uuden Pokemon-tietokkohteen tiedot asianomaisela kontrollerilta välittäen ne edelleen tietokantaan tallentaen
		 * ne uuteen Pokemon-tietokohteeseen
		 */
	
		public function save() {
	
			$query = DB::connection()->prepare('INSERT INTO Pokemon (basemon_id, overall_appraisal, stats_appraisal, caught_location, cp) VALUES (:basemon_id, :overall_appraisal, :stats_appraisal, :caught_location, :cp) RETURNING id');
	
			$query->execute(array('basemon_id' => $this->basemon_id, 'overall_appraisal' => $this->overall_appraisal, 'stats_appraisal' => $this->stats_appraisal, 'caught_location' => $this->caught_location, 'cp' => $this->cp));
	
			$row = $query->fetch();
	
			$this->id = $row['id'];
		}

		/**
		 * Metodi update päivittää asianomaisen Pokemon-tietokohteen tiedot tietokannassa asianomaisen kontrollerin sille
		 * antamien tietojen mukaisesti
		 */
	
		public function update() {
	
			$query = DB::connection()->prepare('UPDATE Pokemon SET basemon_id=:basemon_id, overall_appraisal=:overall_appraisal, stats_appraisal=:stats_appraisal, caught_location=:caught_location, cp=:cp WHERE id = :id');
	
			$query->execute(array('id' => $this->id, 'basemon_id' => $this->basemon_id, 'overall_appraisal' => $this->overall_appraisal, 'stats_appraisal' => $this->stats_appraisal, 'caught_location' => $this->caught_location, 'cp' => $this->cp));
	
		}

		/**
		 * Metodi destroy poistaa asianomaisen Pokemon-tietokohteen tiedot tietokannasta asianomaisen kontrollerin käskyn vastaan ottaen
		 */
	
		public function destroy() {
	
			$query = DB::connection()->prepare('DELETE FROM Pokemon WHERE id=:id');
	
			$query->execute(array('id' => $this->id));
	
		}		 

		/**
		 * Metodi validate_o_appraisal varmistaa pokemon-tietokohteen overall_appraisal tietueeseen
		 * lisättävissä tai muutettavissa olevan tiedon oikeellisuudesta
		 */
	
		public function validate_o_appraisal() {
	
			$errors = array();
	
			if ($this->overall_appraisal == '') {
				$errors[] = 'The overall appraisal value cannot be empty.';
	
				return $errors;
	
			}
	
			if(!is_numeric($this->overall_appraisal)) {
				$errors[] = 'The overall appraisal value must be a number.';
	
				return $errors;
	
			}
	
			if(intval($this->overall_appraisal < 1) || intval($this->overall_appraisal > 4)) {
	
				$errors[] = 'Please consult your Team Leader for the appropriate appraisal and convert as follows: 1 = 0%-50%, 2 = 51%-66%, 3 = 67%-79%, 4 = 80%-100%.';
	
				return $errors;
	
			} 	
	
			return $errors;
		}
	
		/**
		 * Metodi validate_s_appraisal varmistaa Pokemon-tietokohteen stats_appraisal-tietueeseen
		 * lisättävän tai muutettavan tiedon oikeellisuuden ennen lisäysten tai muutosten sallimista
		 */
	 
		 public function validate_s_appraisal() {
	
	       	         $errors = array();
		
       		         if ($this->stats_appraisal == '') {
       		                 $errors[] = 'The stats appraisal value cannot be empty.';
		
       		                 return $errors;
		
       		         }
		
       		         if(!is_numeric($this->stats_appraisal)) {
       		                 $errors[] = 'The stats appraisal value must be a number.';
		
       		                 return $errors;
		
       		         }
		
       		         if(intval($this->stats_appraisal < 1) || intval($this->stats_appraisal > 4)) {
		
       		                 $errors[] = 'Please consult your Team Leader for the approrpiate appraisal and convert as follows: 1 = max bonus IV 0-7, 2 = max bonus IV 8-12, 3 = max bonus IV 13-14, 4 = max bonus IV 15';
		
	       	                 return $errors;
		
       		         }
		
       			         return $errors;
		       	 }

		/**
		 * Metodi validate_location varmistaa ennen Pokemon-tietokohteen caught_location-tietueen
		 * tietojen muuttamista tai lisäämistä niiden oikeellisuudesta
		 */
		
		public function validate_location() {
		
			$errors = array();
		
			if($this->caught_location == '' || $this->caught_location == null) {
	
				$errors[] = 'Please enter a location';
		
			}
	
			return $errors;
		}

		/**
		 * Metodi validate_cp varmistaa ennen Pokemon-tietokohteen cp-tietueeseen tiedon
		 * lisäämistä tai muokkaamista tiedon oikeellisuudesta ennenkuin tietoa lisätään tai muokataan
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
