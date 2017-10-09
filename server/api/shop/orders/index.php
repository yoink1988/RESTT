<?php
include_once '../../../lib/config.php';
include ROOT_DIR.'/lib/RestServer.php';
include ROOT_DIR.'/lib/Order.php';

class OrdersController extends RestServer
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
		$this->model = new Order;

    }

    public function getOrders($params=null)
    {
		return $this->model->select($params);
    }
    
    public function postOrders($params)
    {
		$res = $this->model->insert($params);
		echo $res;
    }

    public function putOrders($params)
    {

        if(isset($params['id']) && isset($params['status']))
        {
            $id = array_shift($params);
			$res = $this->model->update($id, $params);
			echo $res;
        }
		else
		{
			echo 'net id ili statusa';
		}
    }

//    public function deleteCars($params)
//    {
//		if(isset($params['id']))
//		{
//			$id = $params['id'];
//		$res = $this->model->delete($id);
//		echo $res;
//		}
//    }


}


try{
$c = new OrdersController;
$c->run();
}
catch (Exception $e)
{
	
	echo $e->getMessage();
}

