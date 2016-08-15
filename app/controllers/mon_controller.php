<?php

	class MonController extends BaseController {
		public static function index() {
			
			$mons = Mon::all();

			View::make('mon/index.html', array('mons' => $mons));
		}

		public static function show($id) {

			$mon = Mon::find($id);
			View::make('mon/view.html', array('mon' => $mon));
		}

		public static function create() {

                        View::make('mon/new.html');
                }


		public static function store() {

			$params = $_POST;

			$mon = new Mon(array(
				'name' => $params['name'],
				'dexnumber' => $params['dexnumber'],
				'attack' => $params['attack'],
				'defense' => $params['defense'],
				'stamina' => $params['stamina']
			)); 

		$mon->save();

		Redirect::to('/mon/' . $mon->id, array('message' => 'Added!')); 

		}

	}
