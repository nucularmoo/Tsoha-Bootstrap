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
			$errors[] = 'Please enter an appropriate overall appraisal value between digits 1 and 4';

			return $errors;

		}

		if(!is_numeric($this->overall_appraisal)) {
			$errors[] = 'Please enter an appropriate overall appraisal value between digits 1 and 4';

			return $errors;

		}

		if(intval($this->overall_appraisal < 1) || intval($this->overall_appraisal > 4)) {

			$errors[] = 'Please enter an appropriate overall appraisal value between digits 1 and 4';

			return $errors;

		} 	

		return $errors;
	}


 
	 public function validate_s_appraisal() {

                $errors = array();

                if ($this->stats_appraisal == '') {
                        $errors[] = 'Please enter an appropriate stats appraisal value between digits 1 and 4';

                        return $errors;

                }

                if(!is_numeric($this->stats_appraisal)) {
                        $errors[] = 'Please enter an appropriate stats appraisal value between digits 1 and 4';

                        return $errors;

                }

                if(intval($this->stats_appraisal < 1) || intval($this->stats_appraisal > 4)) {

                        $errors[] = 'Please enter an appropriate stats appraisal value between digits 1 and 4';

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
