<?php
/**
 * Description of Car
 *
 * @author yoink
 */
class Order
{
	private $db;
	public function __construct()
	{
		$pdoOpts = MYSQL_HOST;
		$user = MYSQL_USER;
		$pass = MYSQL_PASS;
		$this->table = 'orders';
        $this->db = new PDO($pdoOpts,$user,$pass);
	}

	public function select($params=null)
	{
		$q = "select id, id_user, id_car, payment, status from $this->table ";
		if($params['id'])
		{
			$id = $this->db->quote($params['id']);
			$q .= "where id = $id";
		}
//		echo $q;
//		exit();
		$stmt = $this->db->query($q);
		$result = [];
		while($res = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$result[]=$res;
		}
		if(!$result)
		{
			throw new Exception('Not found');
		}
		return $result;
	}
	
	public function insert($params=null)
	{
		$q = "insert into $this->table (id_user, id_car, payment) values (";
        if(count($params == 3))
        {
			$params = $this->clearParams($params);
			foreach ($params as $param)
			{
				$q.= "$param, ";
			}
			$q = substr($q, 0, -2);
			$q.=')';

			if($this->db->exec($q))
			{
				return 'success';
			}
			else
			{
				throw new Exception('Ne dobavilos');
			}
        }
        else
        {
            throw new Exception('all fields are required');
        }
	}
	
	public function update($id, $params)
	{
		$id = $this->db->quote($id);
		$params = $this->clearParams($params);

		$q = "update $this->table set ";
		foreach($params as $k => $v)
		{
			$q .= "{$k} = {$v}, ";
		}
		$q = substr($q, 0, -2);

		$q .="where id = $id";
		if($this->db->exec($q))
		{
			return 'changed';
		}
		else
		{
			throw new Exception('ne changed');
		}
	}

	private function clearParams($params)
	{
		$cleared = [];
		foreach ($params as $k => $v)
		{
			$cleared[$k] = $this->db->quote($v);
		}
		return $cleared;
	}

}