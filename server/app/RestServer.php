<?php

//include_once 'lib/config.php';
class RestServer
{
    public $args;
    public function __construct()
    {
        $this->reqMethod = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->parseUrl();
    }

    protected function parseUrl()
    {
        $tmp = explode('api/', $this->url);
        $this->controller = ucfirst(explode('/', $tmp[1])[0]);
        $model = explode('/', $tmp[1])[1];
        $arrString = explode($model.'/', $tmp[1])[1];
        $this->model = ucfirst($model);
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
            $this->execMethod('get'.$this->model);
            break;
        case 'DELETE':
            $this->execMethod('delete'.$this->model);
            break;
        case 'POST':
            $this->args = $this->getPostArgs();
            $this->execMethod('post'.$this->model);
            break;
        case 'PUT':
            $this->args = $this->getPutArgs();
            $this->execMethod('put'.$this->model);
            break;
        default:
            return false;
        }
        //var_dump($this); 

    }
    protected function execMethod($meth)
    {
        if ( method_exists($this, $meth) )
        {
            $res = $this->$meth($this->args);
            //endpoint
            echo '<pre>';
            var_dump($this);
        }
        else
        {
            throw new Exception('MEthod not found');
        }
    }
    protected function getPostArgs()
    {
        return $_POST;
    }
    protected function getPutArgs()
    {
        $arr = [];
        $data = file_get_contents('php://input');
        $exploded = explode('&', $data);
        foreach($exploded as $pair)
        {
            $item = explode('=', $pair);
            if(count($item) == 2)
            {
                $arr[urldecode($item[0])] = urldecode($item[1]);
            }
        }
        return $arr;
    }
}
