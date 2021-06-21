<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class ActivityLogController extends BaseController {

    public function index(){
        $this->loadView('transaction_logs');
    }
}