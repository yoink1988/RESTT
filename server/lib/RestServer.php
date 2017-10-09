<?php

include_once 'config.php';
include_once 'View.php';
class RestServer
{
    public $args;
    public function __construct()
    {
        $this->reqMethod = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->parseUrl();
		$this->view = new View($this->responseType);
    }

    protected function parseUrl()
    {
        $tmp = explode('api/', $this->url);
        $this->controller = ucfirst(explode('/', $tmp[1])[0]);
        $model = explode('/', $tmp[1])[1];
        $arrString = explode($model.'/', $tmp[1])[1];
        $this->funcBody = ucfirst($model);
        if(strripos($tmp[1], '.'))
        {
            $this->responseType = array_pop(explode('.', $tmp[1]));
            $tmpArr = explode('/', preg_replace('/\.\w+$/', '', $arrString));
        }
        else
        {
            $this->responseType = DEFAULT_OUTPUT;
            $tmpArr = explode('/', $arrString);
        }
        if($tmpArr[0] !== "")
        {
            $argPare = array_chunk($tmpArr, 2);
            if((count($tmpArr) % 2) == 0)
            {
                foreach($argPare as $pair)
                {
                    $arg[$pair[0]] = $pair[1];
                    $this->args = $arg;
                }
            }
            else
            {
                if((int)$tmpArr[0])
                {
                    $this->args['id'] = $tmpArr[0];
                }
                else
                {
                    throw new Exception('Bad REquest');
                }
            }
        }
        else
        {
            $this->args = null;
        }
    }
    public function run()
    {
        switch($this->reqMethod)
        {
        case 'GET':
            $this->execMethod('get'.$this->funcBody);
            break;
        case 'DELETE':
            $this->execMethod('delete'.$this->funcBody);
            break;
        case 'POST':
            $this->args = $this->getPostArgs();
            $this->execMethod('post'.$this->funcBody);
            break;
        case 'PUT':
            $this->getPutArgs();
            $this->execMethod('put'.$this->funcBody);
            break;
        case 'OPTIONS':
			header('Access-Control-Allow-Methods: PUT');
			header('Access-Control-Allow-Origin: *');
			header('HTTP/1.0 200 OK');
			exit();
            break;
        default:
            return false;
        }
 

    }
    protected function execMethod($meth)
    {
//		echo file_get_contents("php://input");

		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Credentials: true');
		file_put_contents('tempp.txt', print_r($this->args, true));
//		exit();
//		return $_POST;
//		print_r($this->args);
//		exit();
        if ( method_exists($this, $meth) )
        {


            $res = $this->$meth($this->args);
			$this->view->doResponse($res);
        }
        else
        {
			exit();
            throw new Exception('MEthod not found');
        }
    }
    protected function getPostArgs()
    {

        return $_POST;
    }
    protected function getPutArgs()
    {
        $this->args = json_decode(file_get_contents("php://input"), true);
//        parse_str(file_get_contents("php://input"), $this->args);
    }
}
