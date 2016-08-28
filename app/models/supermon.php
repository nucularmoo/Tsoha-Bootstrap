<?php
	class Supermon extends BaseModel {

		public $id, $name, $basemon_id, $overall_appraisal, $stats_appraisal, $caught_location, $cp;

		public function __construct($attributes) {
		
			parent::__construct($attributes);
		}

		public static function all() {

			$query = DB::connection()->prepare('SELECT* FROM POKEMON INNER JOIN BASE_POKEMON ON POKEMON.BASEMON_ID = BASE_POKEMON.DEXNUMBER');
			$query->execute();
			$rows = $query->fetchAll();
			$supermons = array();

			foreach($rows as $row) {

				$supermons[] = new Supermon(array(

					'id' => $row['id'],
					'name' => $row['name'],
					'basemon_id' => $row['basemon_id'],
					'overall_appraisal' => $row['overall_appraisal'],
					'stats_appraisal' => $row['stats_appraisal'],
					'caught_location' => $row['caught_location'],
					'cp' => $row['cp']

				));
			}

			return $supermons;
			
		}

		public static function find($id) {

			$query = DB::connection()->prepare('SELECT * FROM POKEMON INNER JOIN BASE_POKEMON ON POKEMON.BASEMON_ID = BASE_POKEMON.DEXNUMBER WHERE POKEMON.ID = :id LIMIT 1');
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if($row) {

				$supermon = new Supermon(array(

					'id' => $row['id'],
					'name' => $row['name'],
					'basemon_id' => $row['basemon_id'],
					'overall_appraisal' => $row['overall_appraisal'],
					'stats_appraisal' => $row['stats_appraisal'],
					'caught_location' => $row['caught_location'],
					'cp' => $row['cp']
				));

				return $supermon;

			}

			return null;

		}

	}

			
