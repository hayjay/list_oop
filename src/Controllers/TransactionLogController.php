<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionLogModel;

class TransactionLogController extends BaseController {

    public $model = '';
    public function __construct()
    {
        // if(!isset($_SESSION['user'])){
        //   header('location:/');
        // }
        parent::__construct();
        $this->model = new TransactionLogModel();
    }

    /*
     * Show All list.
     * @return json response of transactionlogs or error with error message
     */
    public function index($parameters = ''){
        $where = [];
        if(!empty($parameters[0])){
            $where['status'] = filter_var($parameters[0], FILTER_VALIDATE_INT) - 1;
        }

        $list = $this->model->getTransactionLogs([],$where);
        $total = $this->model->countLists([]) ?? 0;
        $total_pending = $this->model->countLists(['status' => 0]) ?? 0;
        if($total === false){
            return $this->utilityObject->jsonResponse([
                'status' => 'error',
                'message' => 'Please check  $database_credentials in src/Core/Config.php.Also check Database/alter_query.sql for any alter'
             ]);
        }
        return $this->utilityObject->jsonResponse([
            'status' => 'success',
            'data' => $list,
            'total' => $total,
            'pending' => $total_pending,
        ]);
    }
}