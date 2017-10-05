<?php
include '../../../app/RestServer.php';
class Cars extends RestServer
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        
        
        $this->db new PDO(/* pdo params*/ );

    }

    public function getCars($params=null)
    {

        if(!$params)
        {
            $q = 'select id, brand, model, motor, speed, color, price from cars';
                    
        }
        else
        {
            ///quote params
            //add them to query (where)
        }
        //exec query
        echo 'get';
    }
    
    public function postCars($params)
    {
        if(count($params == 7))
        {
            //quote params
            //make column string
            $q = 'insert into cars (id,)'
        }
        else
        {
            //throw new ....
        }
        echo 'post';
    }

    public function putCars($params)
    {
        if(isset($params['id']))
        {
            
        }
        echo 'put';
    }

    public function deleteCars($params)
    {
        echo 'delete';
    }    
}

$c = new Cars;
$c->run();

