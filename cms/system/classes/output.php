<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

class Output {

	private $struct = null;
	private $mode = 'json';
	private $outputBuffer = '';
	private $retName = 'ret';
	private $useRet = true;
	private $useStatus = true;
	private $useErrors = true;

public function __construct($retName='ret', $useStatus=true, $useErrors=true){
	
	$this->useRet = $retName === false ? false : true;
	$this->useStatus = $useStatus === false ? false : true;
	$this->useErrors = $useStatus === false ? false : true;
	
	if($this->useRet !== false) $this->retName = $retName;
	
	$this->struct = array(

		'status' => 'idle', // [ success | error | mixed ]
		'errors' => array(), // error code [ array( $code, $descr ) ]
		$this->retName => false // returned value(s)

	);

}

public function mode($str=null) { // [ json | html ]

	switch($str){
		case 'json':
		default:
		
			$this->mode = 'json';
		
		break;
		
		case 'html':
		
			$this->mode = 'html';
		
		break;
		
		case 'text':
		
			$this->mode = 'text';
		
		break;
		
	}
	
	return $this->mode;

}

public function setRetName($name){
	
	if($name == 'status' || $name == 'error') return -1;
	if(!isset($this->struct)) $self->__construct();
	
	$this->struct[$name] = $this->struct[$this->retName];
	unset($this->struct[$this->retName]);
	$this->retName = $name;
	
	return $this->retName;
	
}

public function status($str=null) {

	if(!is_null($str) || !empty($str) || !preg_match('~^(success|error|mixed|idle)$~',$str))
		$this->struct['status'] = $str;
		
	return $this->struct['status'];

}

public function success() {

	$this->status('success');
		
	return $this->struct['status'];

}

public function error($enum=null, $descr=null){

	if(!is_null($enum) && (is_int($enum) || $enum === false)){
	
		$this->status('error');
		$this->struct['errors'][] = array($enum, $descr);
		
	}elseif(is_null($enum) && is_null($descr)){
	
		$this->status('error');
		return $this->struct['status'];
	
	}
		
	return $this->struct['errors'];

}
    
public function errorsCnt(){
 
    return is_array($this->struct['errors']) ? sizeof($this->struct['errors']) : 0;
    
}

public function data($data=null){

	if(!is_null($data))
		$this->struct[$this->retName] = $data;
		
	return $this->struct[$this->retName];

}

public function startGetBuffer(){

	ob_start();

}

public function endGetBuffer(){

	$this->outputBuffer = ob_get_contents();
	ob_end_clean();
	
	return $this->outputBuffer;

}

public function render(){

	switch($this->mode){
		case 'json':
			
			$tmpData = $this->struct;
			
			if(sizeof($tmpData['errors']) > 0 && $tmpData['status'] == 'iddle') $tmpData['status'] = 'error';

			if($this->useRet){
			
				if(!$this->useStatus) unset($tmpData['status']);
				if(!$this->useErrors) unset($tmpData['errors']);
			
			}else{
			
				$tmpData = $tmpData[$this->retName];
			
			}
			
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($tmpData);
			unset($tmpData);
		
		break;
		
		case 'html':
		
			header('Content-Type: text/html; charset=utf-8');
			echo $this->outputBuffer;
		
		break;
		
		case 'text':
		
			header('Content-Type: text/plain; charset=utf-8');
			echo $this->outputBuffer;
		
		break;
		
	}

}

}

?>