<?php

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
		echo 'Tämä on etusivu';
   	 }

   	 public static function sandbox(){
      // Testaa koodiasi täällä
     		 View::make('helloworld.html');
    	}
  }
