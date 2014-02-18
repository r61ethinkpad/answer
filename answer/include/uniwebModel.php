<?php
/**
 * @author weijuan
 */
 
class uniwebModel
{
    private $ch;
    private $commands = array();
	
	public $baseurl;
	public $clientid;
    public $timeout;
	
    public function __construct()
    {


        $this->commands = require(dirname(__FILE__).'/../config/commands.php');
    }
	
	private function init()
	{
		$this->ch = null;
	    $this->ch = curl_init();
		
		$config = spExt('uniweb');
		$this->baseurl = $config['baseurl'];
		$this->clientid = $config['clientid'];
		$this->timeout = $config['timeout'];
		
        curl_setopt($this->ch, CURLOPT_HEADER, 1);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("From: ".$this->clientid,"Content-Type: application/octet-stream"));
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_POST, 1);

        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
	}

    public function call($cmdid, $params, &$data)
    {
        if(strlen($cmdid)==8 && substr($cmdid,0,1)=='1')
        {
            
        }
        else
        {
            if(!array_key_exists($cmdid, $this->commands))
                return -2;
            $cmdid = $this->commands[$cmdid];
        }
		//dump( $cmdid);
		$this->init();
		
        curl_setopt($this->ch, CURLOPT_URL, $this->baseurl.'0x'.$cmdid);
		//dump($params);
		//if(empty($params))
        $post_data = bson_encode($params);
        
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);
		
		$output = curl_exec($this->ch);
		//dump($output);
		
        if ($error = curl_error($this->ch) )
        {
			//$data = $error;
            return -3;
        }
		
		$curl_info = curl_getinfo($this->ch);
		$curl_code = $curl_info['http_code'];
        //$curl_code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);        //获取http返回值
		
        if( $curl_code == 200 )
        {
        }else{
			//$data = $curl_code;
			return -4;
		}

        if ($output === false)
        {
            //throw new Exception("curl_exec error for command $cmdid.");
            return -5;
        }
		
		$header = substr($output, 0, $curl_info['header_size']);
		if($curl_info['download_content_length'] <> 0)
			$body = substr($output, -$curl_info['download_content_length']);
		
		//file_put_contents('\mongo'.time().'.out',$output);
        //list($header, $body) = explode("\r\n\r\n", $output, 2);
		
		/*if( trim($body) == '')
		{
			//echo "http body is null";
			return -5;
		}*/
        
        $header_ = explode("\r\n", $header);
        $header_a = array();
        foreach($header_ as $s)
        {
            if(strpos($s, ':') === False) continue;
            list($k,$v) = explode(':',$s,2);
            $header_a[$k] = $v;
        }

        curl_close($this->ch);
		
		list($cmdid,$cmdstatus) = explode(':',$header_a['Etag']);
        $cmdstatus = hexdec($cmdstatus);
		
		if( trim($body) <> '' ){
			$data = bson_decode($body);
			if($data === false)
				return -6;
			
			//memcache中转数据
			if(isset($data['mcdata']))
			{
				$data = spClass('spAccessCache')->memcache('r',$data['mcdata']);
				$data = bson_decode($data);
				//print_r($data);
			}
			
			//redis中转数据
			if(isset($data['rediskey']))
			{	//dump($data);
				$redis = new Redis();
				$rconfig = spExt('redis');
				$redis->connect($rconfig['redis_host'], $rconfig['redis_port']);
				//dump($data['rediskey']);
				$data = $redis->get($data['rediskey']);
				//dump($data);
				if($data <> '')
					$data = bson_decode($data);
				else
					$data = '';
			}
		}
		else{
			$data = '';
		}
        
        
        
        return $cmdstatus;
        
    }

    public function query($cmdid, $params, &$data)
    {

    }

    public static function list2map($rs)
    {
        $titles = explode(',',$rs['cols']);
        if(count($titles)<1)
            return false;
        if(count($rs['data'])<1)
            return false;
        $rows = array();
        foreach($rs['data'] as $row)
        {
            $r = array();
            $i = 0;
            foreach($row as $cols)
            {
                $r[trim($titles[$i])] = $cols;
                $i++;
            }
            $rows[] = $r;

        }
        return $rows;
    }

}
