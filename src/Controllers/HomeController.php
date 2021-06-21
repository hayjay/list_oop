<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController {

    public function index(){
    	// if(!isset($_SESSION['user'])){
     //      header('location:/');
     //    }
        $this->loadView('home');
    }
}