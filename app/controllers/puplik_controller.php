<?php

	class PublicController extends BaseController {

		public static function index() {
			
			$mons = Supermon:: all();
			View::Make('puplik/index.html', array('mons' => $mons));

		}

	}
