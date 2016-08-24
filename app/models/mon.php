<?php
class Mon extends BaseModel {

	//Attribuutit
	public $id, $dexnumber, $name, $overall_appraisal, $stats_appraisal, $caught_location, $cp;

	//Konstruktori
	public function __construct($attributes) {
		parent::__construct($attributes);
		$this->validators = array('validate_name','validate_dexnumber', 'validate_o_appraisal', 'validate_s_appraisal', 'validate_location', 'validate_cp');
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM pokemon');

		$query->execute();

		$rows = $query->fetchAll();

		$mons = array();

		
		foreach($rows as $row) {

			$mons[] = new Mon(array(
				'id' => $row['id'],
				'dexnumber' => $row['dexnumber'],
				'name' => $row['name'],
				'overall_appraisal' => $row['overall_appraisal'],
				'stats_appraisal' => $row['stats_appraisal'],
				'caught_location' => $row['caught_location'],
				'cp' => $row['cp']
			));
		}

		return $mons;
	}

	public static function find($id) {

		$query = DB::connection()->prepare('SELECT * FROM pokemon WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row) {

			$mon = new Mon(array(
				'id' => $row['id'],
                                'dexnumber' => $row['dexnumber'],
                                'name' => $row['name'],
                                'overall_appraisal' => $row['overall_appraisal'],
                                'stats_appraisal' => $row['stats_appraisal'],
                                'caught_location' => $row['caught_location'],
                                'cp' => $row['cp']

			));

			return $mon;

		}
					
	}

	public function save() {

		$query = DB::connection()->prepare('INSERT INTO Pokemon (name, dexnumber, overall_appraisal, stats_appraisal, caught_location, cp) VALUES (:name, :dexnumber, :overall_appraisal, :stats_appraisal, :caught_location, :cp) RETURNING id');

		$query->execute(array('name' => $this->name, 'dexnumber' => $this->dexnumber, 'overall_appraisal' => $this->overall_appraisal, 'stats_appraisal' => $this->stats_appraisal, 'caught_location' => $this->caught_location, 'cp' => $this->cp));

		$row = $query->fetch();

		$this->id = $row['id'];
	}

	public function update() {

		$query = DB::connection()->prepare('UPDATE Pokemon SET name=:name, dexnumber=:dexnumber, overall_appraisal=:overall_appraisal, stats_appraisal=:stats_appraisal, caught_location=:caught_location, cp=:cp WHERE id = :id');

		$query->execute(array('id' => $this->id, 'name' => $this->name, 'dexnumber' => $this->dexnumber, 'overall_appraisal' => $this->overall_appraisal, 'stats_appraisal' => $this->stats_appraisal, 'caught_location' => $this->caught_location, 'cp' => $this->cp));

	}

	public function destroy() {

		$query = DB::connection()->prepare('DELETE FROM Pokemon WHERE id=:id');

		$query->execute(array('id' => $this->id));

	}

	public function validate_name() {
		
		$errors = array();

		if($this->name == '' || $this->name == null) {

			$errors[] = 'Field "name" cannot be empty';
		}

		if(strlen($this->name) < 3) {
		
			$errors[] = 'Field *name" must be at least three characters';
		}

		return $errors;
	}

	public function validate_dexnumber() {
		
		$errors = array();

		if($this->dexnumber == '' || $this->dexnumber == null) {

			$errors[] = 'Field "dexnumber" cannot be empty';

			return $errors;

		}

		if(!is_numeric($this->dexnumber)) {
			$errors[] = 'Field "dexnumber" must be a number';

			return $errors;
		}

		if(intval($this->dexnumber < 1)) {
			$errors[] = 'Dexnumber must be a number larger than 0';

			return $errors;

		}

		return $errors;

		
	}

		 

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

	public function validate_location() {

		$errors = array();

		if($this->caught_location == '' || $this->caught_location == null) {

			$errors[] = 'Please enter a location';

		}

		return $errors;
	}

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
