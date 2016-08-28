<?php
	require 'app/models/basemon.php';

	class MonController extends BaseController {
		public static function index() {
			
			$mons = Mon::all();

			View::make('mon/index.html', array('mons' => $mons));
		}

		public static function show($id) {

			$mon = Mon::find($id);
			View::make('mon/view.html', array('mon' => $mon));
		}

		   public static function edit($id) {

                        $mon = Mon::find($id);
                        View::make('mon/edit.html', array('mon' => $mon));
                }


		public static function create() {

			$basemons = Basemon::all();

                        View::make('mon/new.html');
                }


		public static function store() {

			$params = $_POST;

			$attributes = array(
				'name' => $params['name'],
				'dexnumber' => $params['dexnumber'],
				'overall_appraisal' => $params['overall_appraisal'],
				'stats_appraisal' => $params['stats_appraisal'],
				'caught_location' => $params['caught_location'],
				'cp' => $params['cp']
			); 

			$mon = new Mon($attributes);

			$errors = $mon->errors();

			if(count($errors) == 0) {

				$mon->save();
		

			Redirect::to('/mon/' . $mon->id, array('message' => 'Added!')); 

			} else {
	
			View::make('mon/new.html', array('errors' => $errors, 'attributes' => $attributes));

			}

		}



		public static function update($id) {

			$params = $_POST;

			$attributes = array(
				'id' => $id,
				'name' => $params['name'],
				'dexnumber' => $params['dexnumber'],
				'overall_appraisal' => $params['overall_appraisal'],
				'stats_appraisal' => $params['stats_appraisal'],
				'caught_location' => $params['caught_location'],
				'cp' => $params['cp']
			);

			$mon = new Mon($attributes);
			$errors = $mon->errors();

			if(count($errors) > 0) {
				View::make('mon/edit.html', array('errors' => $errors, 'mon' => $attributes));

			} else {

				$mon->update();

				Redirect::to('/mon/' . $mon->id, array('message' => 'Edit successful!'));
			}

		}

		public static function destroy($id) {

			$mon = new Mon(array('id' => $id));

			$mon->destroy();

			Redirect::to('/mon', array('message' => 'Pokémon successfully deleted!'));
		}
	}
