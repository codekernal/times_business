<?php 
class ContentRepo{

	public function getContents($request)
	{
			$requestData = $request;
			// Initial response is bad request
			//$response = 400;

			
				$contents = $GLOBALS['con']->from('content');
				$data 	  = array();

				foreach($contents as $content)
		    	{
		    		$contentData = $this->getContent(array('id' => $content['id']));
					$data[] 	 = $contentData['data'];
				}

				$response = 200;
			
			return array('code' => $response,'data' => $data);
			
	}

	public function getContent($request)
	{
			$response = 400;

			$data    = array();
			$content = $GLOBALS['con']->from('content')->where('id',$request['id']);

			foreach($content as $contents)
		    {
				$data = $contents;
			}

			$response = 200;
			
			return array('code' => $response,'data' => $data);
			
	}

	public function deleteContent($request)
	{
		$id = $request['id'];
		$response = 400;

		if(!empty($id))
		{
			$count = $GLOBALS['con']->from('content')->where('id',$id)->count();
			if($count > 0)
			{
				$query 		= $GLOBALS['con']->deleteFrom('content')->where('id', $id)->execute();
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

	public function addContent($request)
	{
		$response = 400;
		if(!empty($request))
		{
			
				$values = array('content' => $request['content'],'menue_id' => $request['menue_id'] ,'path' => $request['path'], 'date_created' => date("Y-m-d H:i:s"));
				$query  = $GLOBALS['con']->insertInto('content', $values)->execute();

				$response = '200';
			
		}
		else
		{
			$response = '400';
		}


			return $response;

	}

	public function editContent($request)
	{
		$response = 400;

		if(!empty($request['id']))
		{
			$count = $GLOBALS['con']->from('content')->where('id',$request['id'])->count();

			if($count > 0)
			{
					$values = array('id' => $request['id'],'menue_id' => $request['menue_id'] ,'content' => $request['content'],'path' => $request['path'], 'date_created' => date("Y-m-d H:i:s"));
					$query = $GLOBALS['con']->update('content', $values, $request['id'])->execute();

					$response = 200;
			}
			else
			{
				$response = 400;
			}
		}
		return $response;
	}



}