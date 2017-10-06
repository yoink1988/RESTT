<?php
include_once '../../../lib/config.php';
include ROOT_DIR.'/lib/RestServer.php';
include ROOT_DIR.'/lib/Car.php';

class CarsController extends RestServer
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
		$this->model = new Car;
    }

    public function getCars($params=null)
    {
		return $this->model->select($params);
//		var_dump($res);
    }
    
    public function postCars($params)
    {
		$res = $this->model->insert($params);
		echo $res;
    }

    public function putCars($params)
    {
//		file_put_contents('tempp.txt', print_r($params, true));
        if(isset($params['id']))
        {
            $id = array_shift($params);
			$res = $this->model->update($id, $params);
        }
		else
		{
			echo 'net id';
		}
    }

    public function deleteCars($params)
    {
		if(isset($params['id']))
		{
			$id = $params['id'];
		$res = $this->model->delete($id);
		echo $res;
		}
    }


}
//echo '<pre>';
//var_dump($_SERVER);

try{
$c = new CarsController;
$c->run();
}
catch (Exception $e)
{
	echo $e->getMessage();
}

