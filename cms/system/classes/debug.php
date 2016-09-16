<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

require_once 'libs/pear/Benchmark/Timer.php';

class Debug extends Benchmark_Timer {

private $memory_usage = array();
static private $instance = null;

static function getInstance(){

	if (self::$instance == null){
		self::$instance = new Debug();
	}
	return self::$instance;

}

public function timeStart($name='Start'){
	if(debug_mode){
		$this->memory_usage[] = array('time'=>microtime(true),'title'=>$name,'mem'=>memory_get_usage());
		$this->start();
	}
}

public function timeStop($name='Stop'){
	if(debug_mode){
		$this->memory_usage[] = array('time'=>microtime(true),'title'=>$name,'mem'=>memory_get_usage());
		if(sizeof($this->memory_usage)==0) $this->timeStart();
		$this->stop();
	}
}

public function timeMarker($name){
	if(debug_mode){
		$this->memory_usage[] = array('time'=>microtime(true),'title'=>$name,'mem'=>memory_get_usage());
		if(sizeof($this->memory_usage)==0) $this->timeStart();
		$this->setMarker($name);
	}
}

public function render(){
	if(debug_mode){
		echo '<table border="1"><tr><th>Метка</th><th>Использование (МБ)</th><th>Больше на (МБ)</th></tr>';
		foreach($this->memory_usage as $i=>$mu){
			echo '<tr><th>'.$mu['title'].'</th><td>'.round($mu['mem']/1048576,4).'</td><td>'.(isset($this->memory_usage[$i-1]['mem'])?round(($mu['mem']-$this->memory_usage[$i-1]['mem'])/1048576,4):'-').'</td></tr>';
		}
		echo '<tr><th>Пик</th><td colspan="2">'.round(memory_get_peak_usage(true)/1048576,4).'</td></tr></table>';
		$this->display();
	}
}

}

?>