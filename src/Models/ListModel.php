<?php
namespace App\Models;

use App\Models\BaseModel;
use App\Events\ListCreated;
use App\Services\LogTransactionService;

class ListModel extends BaseModel {

    public function __construct()
    {
        parent::__construct();

        if(!$this->hasConnection()){
            $connection_response = $this->makeConnection();
            if(!$this->utilityObject->isSuccessResponse($connection_response)){
                die($connection_response['message']);
            }
        }
        $this->setTableName('task');
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

    /*
     * fetches the list related row info
     *
     * @param array $select select statement of SQL
     * @param array $where where statement of SQL
     *
     * @return array of row result or [] if error
     */
    public function getLists($select = [],$where = []){
        $response = $this->executeORM(['where' => 'user_id = 40','select' => $select]);
        if($this->utilityObject->isSuccessResponse($response)){
            (new LogTransactionService(['description' => 'Viewed All Lists.']))->run();
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
    public function add($data = []){
        if(!empty($data)){
            $result = $this->executeORM(['insert' => true,'data' =>$data]);
            //log transaction
            (new LogTransactionService(['description' => 'Added a new list.']))->run();
            return $result;
        }else{
            return ['status' => 'error', 'message' => 'Data is not given to save.'];
        }
    }

    /*
     * update the list
     *
     * @param int $id primary key of list table
     * @param array $data which data to update
     *
     * @return array of row affected with success or error with error message
     */
    public function updateList($id,$data =[]){
        if(!empty($id)){
            (new LogTransactionService(['description' => 'Updated a list.']))->run();
            return $this->executeORM(['update' => true,'data' =>$data,'where' => ['id' => $id]]);
        }else{
            return ['status' => 'error', 'message' => 'Data is not given to update.'];
        }
    }

    /*
     * delete the list
     *
     * @param int $id primary key of list table
     *
     * @return array of row affected with success or error with error message
     */
    public function deleteList($id){
        if(!empty($id)){
            (new LogTransactionService(['description' => 'Deleted a list.']))->run();
            return $this->executeORM(['delete' => true,'where' => ['id' => $id]]);
        }else{
            return ['status' => 'error', 'message' => 'Data is not given to update.'];
        }
    }

    /*
     * remove complete list from list table
     *
     * @return array of row affected with success or error with error message
     */
    public function removeCompleted(){
        return $this->executeORM(['delete' => true,'where' => ['status' => 1]]);
    }
}