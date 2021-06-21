<?php
namespace App\Events;

use App\Events\BaseEvent;
use App\Models\TransactionLogModel;
/**
 * summary
 */
class ListCreated extends BaseEvent
{
	private $data;
    /**
     * summary
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function run()
    {
    	$this->listen('list_created', function($param){
    		TransactionLogModel::add([
    		        'description' => 'Added a new list event',
    		        'user_id' => 1
    		]);
    	});
    }
}


 ?>