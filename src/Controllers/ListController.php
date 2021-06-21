<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ListModel;

class ListController extends BaseController {

    public $model = '';
    public function __construct()
    {
        session_start();
        parent::__construct();
        $this->model = new ListModel();
    }

    /*
     * Show All list.
     * @return json response of list info or error with error message
     */
    public function index($parameters = ''){
        $where = [];
        if(!empty($parameters[0])){
            $where['status'] = filter_var($parameters[0], FILTER_VALIDATE_INT) - 1;
        }

        $list = $this->model->getLists([],$where);
        $total = $this->model->countLists([]);
        $total_pending = $this->model->countLists(['status' => 0]);
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

    /*
     * add a list
     *
     * POST method to add a list
     *
     * @return json response of newly created list info or error with error message
     */
    public function add(){
        $response = [
            'status' =>'error',
            'message' => 'Something went wrong.Error code: TCA1'
        ];
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST["title"])){
               $title = trim(htmlspecialchars($_POST["title"]));
               $time = date('Y-m-d h:i:s');
              $response = $this->model->add([
                   'title' => $title,
                   'status' => 0,
                   'created' => $time,
                   'modified' => $time,
                   'user_id' => $_SESSION['user'] ?? null
               ]);
            }
        }else{
            $response['message'] = 'Expected POST method.';
        }
        rtn:
        $this->utilityObject->jsonResponse($response);
    }

    /*
     * add a list
     *
     * POST method to add a list
     *
     * @return json response of newly created list info or error with error message
     */
    public function complete(){
        $response = [
            'status' =>'error',
            'message' => 'Something went wrong.Error code: TCC1'
        ];
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST["id"])){
               $id = filter_var($_POST["id"], FILTER_VALIDATE_INT);
               $model_task =$this->model;
              $response = $model_task->updateTask($id,['status' => 1]);
            }
        }else{
            $response['message'] = 'Method should be post.';
        }
        rtn:
        $this->utilityObject->jsonResponse($response);
    }

    /*
     * remove all completed list
     *
     * POST method to remove all completed list
     *
     * @return json response of row affected list count with success or error with error message
     */
    public function removeCompleted(){
        $response = [
            'status' =>'error',
            'message' => 'Something went wrong.'
        ];
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $model_task =$this->model;
            $response = $model_task->removeCompleted();
        }else{
            $response['message'] = 'Method should be post.';
        }
        rtn:
        $this->utilityObject->jsonResponse($response);
    }

    /*
     * delete a list
     *
     * POST method to delete a list
     *
     * @return json response of primary key of deleted task with success or error with error message
     */
    public function delete(){
        $response = [
            'status' =>'error',
            'message' => 'Something went wrong.'
        ];
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST["id"])){
                $id = filter_var($_POST["id"], FILTER_VALIDATE_INT);
                $response = $this->model->deleteList($id);
            }
        }else{
            $response['message'] = 'Method should be post.';
        }
        rtn:
        $this->utilityObject->jsonResponse($response);
    }

    /*
     * edit a list
     *
     * POST method to edit a list
     *
     * @return json response of currently edited list info with success or error with error message
     */
    public function edit(){
        $response = [
            'status' =>'error',
            'message' => 'Something went wrong.'
        ];
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST["id"])){
                $id = filter_var($_POST["id"], FILTER_VALIDATE_INT);
                $title = trim(htmlspecialchars($_POST["title"]));
                $time = date('Y-m-d h:i:s');
                $response = $this->model->updateList($id,['title' => $title,'modified' => $time]);
            }
        }else{
            $response['message'] = 'Method should be post.';
        }
        rtn:
        $this->utilityObject->jsonResponse($response);
    }
}