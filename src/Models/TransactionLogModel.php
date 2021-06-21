<?php
namespace App\Models;

use App\Models\CoreModel;


class TransactionLogModel extends BaseModel {

    public $table_name = 'transaction_logs';

    public function __construct()
    {
        parent::__construct();

        if(!$this->hasConnection()){

            $connection_response = $this->makeConnection();

            if(!$this->utilityObject->isSuccessResponse($connection_response)){
                die($connection_response['message']);
            }
        }

        $this->setTableName($this->table_name);
    }

    /*
     * send the task related row info
     *
     * @param array $select select statement of SQL
     * @param array $where where statement of SQL
     *
     * @return array of row result or [] if error
     */
    public function getTransactionLogs($select = [],$where = []){
        $response = $this->executeORM(['where' => $where,'select' => $select]);
        if($this->utilityObject->isSuccessResponse($response)){
            return $response['result'];
        }
        return [];
    }

    /*
     * add the task
     *
     * @param array $data task related info
     *
     * @return array of last inserted row id with success or error
     */
    public static function add($data = []){
        if(!empty($data)){
            return $this->executeORM(['insert' => true,'data' =>$data, 'table_name' => 'transaction_logs']);
        }else{
            return ['status' => 'error', 'message' => 'Missing data'];
        }
    }

    /*
     * count the lists
     *
     * @param array $where where statement of SQL
     *
     * @return int of row count or 0 if error
     */
    public function countLists($where){
        $response = $this->executeORM(['count' => true,'where' => $where]);
        if($this->utilityObject->isSuccessResponse($response)){
            return $response['result'];
        }
        return 0;
    }
}