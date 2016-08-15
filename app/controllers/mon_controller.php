<?php

	class MonController extends BaseController {
		public static function index() {
			
			$mons = Mon::all();

			View::make('mon/index.html', array('mons' => $mons));
		}
	}
