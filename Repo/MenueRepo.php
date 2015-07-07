<?php 
class MenueRepo{

	public function getMenues($request)
	{
			$requestData = $request;
			// Initial response is bad request
			//$response = 400;

			
				$menues = $GLOBALS['con']->from('menue');
				$data = array();

				foreach($menues as $menue)
		    	{
		    		$menueData = $this->getMenue(array('id' => $menue['id']));
					$data[] = $menueData['data'];
				}

				$response = 200;
			
			return array('code' => $response,'data' => $data);
			
	}

	public function getMenue($request)
	{
			$response = 400;

			$data = array();
			$menue = $GLOBALS['con']->from('menue')->where('id',$request['id']);

			foreach($menue as $items)
		    {
				$data = $items;
			}

			$response = 200;
			
			return array('code' => $response,'data' => $data);
			
	}

	public function deleteMenue($request)
	{
		$id = $request['id'];
		$response = 400;

		if(!empty($id))
		{
			$count = $GLOBALS['con']->from('menue')->where('id',$id)->count();
			if($count > 0)
			{
				$query 		= $GLOBALS['con']->deleteFrom('menue')->where('id', $id)->execute();

				$response 	= 200;
			}
			else
			{
				$response = 400;
			}
		}
		else
		{
			$response = 400;
		}
		return $response;

	}

	public function addMenue($request)
	{
		$response = 400;
		if(!empty($request))
		{
			$count = $GLOBALS['con']->from('menue')->where('slug',$request['slug'])->count();
			if($count > 0)
			{
				$response = 400;
			}
			else
			{
				$values = array('menue_name' => $request['menue_name'],'slug' => $request['slug']);
				$query  = $GLOBALS['con']->insertInto('menue', $values)->execute();

				$response = '200';
			}

			
		}
		else
		{
			$response = '400';
		}


			return $response;

	}

	public function editMenue($request)
	{
		$response = 400;

		if(!empty($request['id']))
		{
			$count = $GLOBALS['con']->from('menue')->where('id',$request['id'])->count();

			if($count > 0)
			{
				$slugcount  = $GLOBALS['con']->from('menue')->where('slug', $request['slug'])->count();
				if($slugcount > 0)
				{
					$response = 400;
				}
				else
				{
					$values = array('id' => $request['id'],'menue_name' => $request['menue_name'],'slug' => $request['slug']);
					$query = $GLOBALS['con']->update('menue', $values, $request['id'])->execute();

					$response = 200;
				}
			}
			else
			{
				$response = 400;
			}
		}
		return $response;
	}



}