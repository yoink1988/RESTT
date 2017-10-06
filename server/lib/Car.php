<?php

/**
 * Description of Car
 *
 * @author yoink
 */
class Car
{
	private $db;
	public function __construct()
	{
		$pdoOpts = MYSQL_HOST;
		$user = MYSQL_USER;
		$pass = MYSQL_PASS;
		$this->table = 'cars';
        $this->db = new PDO($pdoOpts,$user,$pass);
	}

	public function select($params=null)
	{
		$q = "select id, brand, model, year, motor, speed, color, price from $this->table";
        if($params)
        {
			$params = $this->clearParams($params);
			$q.=' where ';
			foreach($params as $k => $v)
			{
				$q .="$k = $v and ";
			}
			$q = substr($q, 0, -5);
        }

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

	public function insert($params)
	{
		$q = 'insert into cars (model, brand, year, motor, speed, color, price) values (';
        if(count($params == 7))
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

	public function delete($id)
	{
		$id = $this->db->quote($id);
		$q = "delete from cars where id = $id limit 1";
		if($this->db->exec($q))
		{
			echo 'deleted';
		}
		else
		{
			throw new Exception('ne udaleno');
		}

	}

	public function update($id, $params)
	{
		$id = $this->db->quote($id);
		$params = $this->clearParams($params);

		$q = 'update cars set ';
		foreach($params as $k => $v)
		{
			$q .= "{$k} = {$v}, ";
		}
		$q = substr($q, 0, -2);

		$q .="where id = $id";
		if($this->db->exec($q))
		{
			echo 'changed';
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
