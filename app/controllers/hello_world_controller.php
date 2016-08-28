<?php

  require'app/models/mon.php';

  class HelloWorldController extends BaseController{

	public static function mon_list(){
		View:: make('suunnitelmat/mon_list.html');
	}	

	public static function login(){
		View:: make('suunnitelmat/login.html');
	}

	public static function mon_show(){
		View::make('suunnitelmat/mon_show.html');
	}

    	public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
		View::Make('suunnitelmat/index.html');
   	 }

   	 public static function sandbox(){
      		$pikachu = Basemon::find_by_id(25);
		$mons = Basemon::all();
//
		Kint::dump($mons);
		Kint::dump($pikachu);

//     		View::make('helloworld.html');

		$vammamon = new Mon(array(

			'name' => 'e',
			'dexnumber' => '23',
			'overall_appraisal' => '56',
			'stats_appraisal' => '-3'

		));

		$errors =$vammamon->errors();

		Kint::dump($errors);
    	}
  }
