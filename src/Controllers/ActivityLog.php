<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class ActivityLog extends BaseController {

    public function index(){
        $this->loadView('transaction_logs');
    }
}