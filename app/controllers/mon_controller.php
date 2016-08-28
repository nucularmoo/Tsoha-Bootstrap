<?php
	require 'app/models/basemon.php';
	require 'app/models/supermon.php';

	class MonController extends BaseController {
		public static function index() {
			
			$mons = Supermon::all();

			View::make('mon/index.html', array('mons' => $mons));
		}

		public static function show($id) {

			$mon = Supermon::find($id);
			View::make('mon/view.html', array('mon' => $mon));
		}

		   public static function edit($id) {

			$basemons = Basemon::all();
                        $mon = Supermon::find($id);
                        View::make('mon/edit.html', array('mon' => $mon, 'basemons' => $basemons));
                }


		public static function create() {

			$basemons = Basemon::all();

                        View::make('mon/new.html', array('basemons' => $basemons));
                }


		public static function store() {

			$basemons = Basemon::all();

			$params = $_POST;

			$basemon_id = $params['basemon_id'];
			$overall_appraisal = $params['overall_appraisal'];

			$attributes = array(
				'basemon_id' => $basemon_id,
				'overall_appraisal' => $overall_appraisal,
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
	
			View::make('mon/new.html', array('errors' => $errors, 'basemons' => $basemons, 'attributes' => $attributes));

			}

		}



		public static function update($id) {

			$basemons = Basemon::all();
			$params = $_POST;

			$basemon_id = $params['basemon_id'];

			$attributes = array(
				'id' => $id,
				'basemon_id' => $basemon_id,
				'overall_appraisal' => $params['overall_appraisal'],
				'stats_appraisal' => $params['stats_appraisal'],
				'caught_location' => $params['caught_location'],
				'cp' => $params['cp']
			);

			$mon = new Mon($attributes);
			$errors = $mon->errors();

			if(count($errors) > 0) {
				View::make('mon/edit.html', array('errors' => $errors, 'basemons' => $basemons, 'mon' => $attributes));

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
