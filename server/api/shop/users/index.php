<?php
include_once '../../../lib/config.php';
include ROOT_DIR.'/lib/RestServer.php';
include ROOT_DIR.'/lib/User.php';

class UsersController extends RestServer
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
		$this->model = new Order;

    }

    public function getUsers($params=null)
    {

		return $this->model->select($params);
//		var_dump($res);
    }
    
    public function postUsers($params)
    {
//		print_r($params);
//		exit();
		if($params['name'] && $params['lname'] && $params['login'] && $params['pass'] )
		{
			$params['pass'] = md5($params['pass']);
			$params['hash'] = $this->generateHash();
		}
		else
		{
			echo 'all fields are required';
		}
			$res = $this->model->insert($params);
			return $res;
    }

    public function putUsers($params)
    {

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

	private function generateHash()
	{
		$length = 6;
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

		$hash = "";

		$clen = strlen($chars) - 1;
		while (strlen($hash) < $length)
		{
			$hash .= $chars[mt_rand(0, $clen)];
		}
		return $hash;
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
$c = new UsersController;
$c->run();
}
catch (Exception $e)
{
	echo $e->getMessage();
}

