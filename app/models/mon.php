<?php
class Mon extends BaseModel {

	//Attribuutit
	public $id, $dexnumber, $name, $typedesc_a_id, $typedesc_b_id, $attack, $defense, $stamina, $evolution_id, $jauheliha;

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
				'typedesc_a_id'  => $row['typedesc_a_id'],
				'typedesc_b_id'  => $row['typedesc_b_id'],
				'attack' => $row['attack'],
				'defense' => $row['defense'],
				'stamina' => $row['stamina'],
				'evolution_id' => $row['evolution_id'],
				'jauheliha' => $row['jauheliha']
			));
		}

		return $mons;
	}

	public static function find($dexnumber) {

		$query = DB::connection()->prepare('SELECT * FROM pokemon WHERE dexnumber = :dexnumber LIMIT 1');
		$query->execute(array('dexnumber' => $dexnumber));
		$row = $query->fetch();

		if($row) {

			$mon = new Mon(array(
				'id' => $row['id'],
                                'dexnumber' => $row['dexnumber'],
                                'name' => $row['name'],
                                'typedesc_a_id'  => $row['typedesc_a_id'],
                                'typedesc_b_id'  => $row['typedesc_b_id'],
                                'attack' => $row['attack'],
                                'defense' => $row['defense'],
                                'stamina' => $row['stamina'],
                                'evolution_id' => $row['evolution_id'],
                                'jauheliha' => $row['jauheliha']
			));

			return $mon;

		}
					
	}
}
?>
