<?php
namespace App\Services;

use App\Models\TransactionLog;
use App\Models\BaseModel;

class LogTransactionService extends BaseModel
{
	private $data;

    public function __construct($data)
    {
        parent::__construct();

        if(!$this->hasConnection()){
            $connection_response = $this->makeConnection();
            if(!$this->utilityObject->isSuccessResponse($connection_response)){
                die($connection_response['message']);
            }
        }

        $this->setTableName('transaction_logs');
        $this->data = $data;
    }

    public function run(){
        $this->data['user_id'] = $_SESSION['user'] ?? null;
    	$this->executeORM([
    	    'insert' => true,
    	    'data' => $this->data
    	]);
    }
}

 ?>