<?php
class Mon extends BaseModel {

	//Attribuutit
	public $id, $dexnumber, $name, $overall_appraisal, $stats_appraisal, $caught_location, $cp;

	//Konstruktori
	public function __construct($attributes) {
		parent::__construct($attributes);
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
}
?>
