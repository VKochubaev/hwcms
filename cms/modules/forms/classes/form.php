<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

class Form {

private $formSructure = array();
//private $nodeWay = array();
private $currentContext = null;
private $currentTPL = 'default';
private $tpl_path = null;

public function __construct($opt){

    if(!is_array($opt)) throw new Exception('Form options error!');
    $opt = $opt + array('id'=>null, 'class'=>null, 'title'=>null);

    $this->tpl_path = array(cmsPath,'modules','forms');
    if(cms_side != 'front')  $this->tpl_path[] = cms_side;
    $this->tpl_path[] = 'tpl';
    $this->tpl_path[] = $this->currentTPL;
    $this->tpl_path = path($this->tpl_path);
    
	$this->formSructure = array(
		'_id' => 0,
		'_'=>'form',
		'_tpl'=>path($this->tpl_path, 'form.tpl'),
		'_tpl_path'=>$this->tpl_path,
		'id'=>$opt['id'],
		'title'=>$opt['title'],
		'_attr'=>array(
			'id'=>$opt['id'],
			'class'=>$opt['class'],
			'title'=>$opt['title'],
			'method'=>'post',
			'action'=>(isset($opt['action']) && !empty($opt['action'])) ? $opt['action'] : './',
			'enctype'=>'multipart/form-data',
			'target'=>'_self'
		),
		'_items'=>array()
	);
	reset($this->formSructure['_items']);
	
	$this->currentContext = 0;

}

public function setFormTPL($str){

	if(!empty($str)) $this->currentTPL = $str;
	return $this->currentTPL;

}

public function setAction($data){
	
	if(empty($data)) return false;
	return $this->formSructure['action'] = $data;

}

public function setMethod($data){
	
	if(empty($data)) return false;
	$data = strtolower($data);
	if(in_array($data, array('get','post'))){
		$this->formSructure['method'] = $data;
		return true;
	}
	return false;

}

public function setEnctype($data){

	if(empty($data)) return false;
	$data = strtolower($data);
	if(in_array($data, array('application/x-www-form-urlencoded','multipart/form-data','text/plain'))){
		$this->formSructure['enctype'] = $data;
		return true;
	}
	return false;

}

public function setTarget($data){
	
	if(empty($data)) return false;
	return $this->formSructure['target'] = $data;

}

private function _getNewKey(){

	end($this->formSructure['_items']);
	return sizeof($this->formSructure['_items'])>0 ? key($this->formSructure['_items'])+1 : 1;

}

public function closeGroup(){

	if(isset($this->formSructure['_items'][$this->currentContext])) {
		if(!isset($this->formSructure['_items'][$this->currentContext]['_parent'])
		|| $this->formSructure['_items'][$this->currentContext]['_parent']==0)
				$this->currentContext = 0;
		else 	$this->currentContext = $this->formSructure['_items'][$this->currentContext]['_parent'];
	}else $this->currentContext = 0;

}

public function openGroup( $id, $title=null, $class=null, $state=null ){

	$key = $this->_getNewKey();
	
	$this->formSructure['_items'][$key] = array(
		'_id' => $key,
		'_parent'=>$this->currentContext,
		'_'=>'group',
		'_tpl'=>path($this->tpl_path, 'group.tpl'),
		'_tpl_path'=>$this->tpl_path,
		'title'=>$title,
		'id'=>$id,
		'_state'=>$state,
		'_attr'=>array(
			'id'=>$id,
			'class'=>$class
		)
	);
	$this->currentContext = $key;
	
	return $this;
	
}

private function _addField( $attr=array(), $data=array() ){
	
	$attr = array_merge(array(
		'type'=>null,
		'name'=>null,
		'title'=>null,
		'id'=>null,
		'class'=>null,
		'value'=>'',
		'placeholder'=>null,
		'reuired'=>false
	), $attr);

	$key = $this->_getNewKey();
	
	switch($attr['type']){
	default: return false; break;
	case 'text': case 'email': case 'tel': case 'url': case 'search':
		
		$this->formSructure['_items'][$key] = array(
			'_id' => $key,
			'_parent'=>$this->currentContext,
			'_'=>$attr['type'],
			'_tpl'=>path($this->tpl_path, 'text.tpl'),
			'_tpl_path'=>$this->tpl_path,
			'_attr'=>$attr
		);
		
	break;
	case 'number':
	
		$this->formSructure['_items'][$key] = array(
			'_id' => $key,
			'_parent'=>$this->currentContext,
			'_'=>$attr['type'],
			'_tpl'=>path($this->tpl_path, 'text.tpl'),
			'_tpl_path'=>$this->tpl_path,
			'_attr'=>array_merge(array(
				'pattern'=>'\d+'
			), $attr)
		);
		
	break;
	case 'textarea':
		$this->formSructure['_items'][$key] = array(
			'_id' => $key,
			'_parent'=>$this->currentContext,
			'_'=>$attr['type'],
			'_tpl'=>path($this->tpl_path, 'tarea.tpl'),
			'_tpl_path'=>$this->tpl_path,
		);
		unset($attr['type']);
		$this->formSructure['_items'][$key]['_attr'] = $attr;
		
	break;
	case 'select':
		
		$this->formSructure['_items'][$key] = array(
			'_id' => $key,
			'_parent'=>$this->currentContext,
			'_'=>$attr['type'],
			'_tpl'=>path($this->tpl_path, $attr['type'].'.tpl'),
			'_tpl_path'=>$this->tpl_path,
			'_attr'=>$attr,
			'_options'=>$data
		);
		
	break;
	case 'checkbox': case 'radio':
		
		$this->formSructure['_items'][$key] = array(
			'_id' => $key,
			'_parent'=>$this->currentContext,
			'_'=>$attr['type'],
			'_tpl'=>path($this->tpl_path, $attr['type'].'.tpl'),
			'_tpl_path'=>$this->tpl_path,			
			'_attr'=>$attr,
		);
		
	break;
	case 'submit': case 'button': case 'reset':
		
		$this->formSructure['_items'][$key] = array(
			'_id' => $key,
			'_parent'=>$this->currentContext,
			'_'=>$attr['type'],
			'_tpl'=>path($this->tpl_path, 'button.tpl'),
			'_tpl_path'=>$this->tpl_path,			
			'_attr'=>$attr,
		);
		
	break;
	case 'hidden':
		
		$this->formSructure['_items'][$key] = array(
			'_id' => $key,
			'_parent'=>$this->currentContext,
			'_'=>$attr['type'],
			'_tpl'=>path($this->tpl_path, 'hidden.tpl'),
			'_tpl_path'=>$this->tpl_path,
			'_attr'=>$attr
		);
		
	break;
	}

	return $this->formSructure['_items'][$key];
	
}

public function textField($title, $name, $value='', $required=false, $id=null, $class=null, $attrs=array()){

	return $this->_addField(
		array_merge(array('type'=>'text', 'name'=>$name, 'title'=>$title, 'id'=>$id, 'class'=>$class, 'value'=>$value, 'placeholder'=>$title, 'required'=>$required),$attrs)
	);

}
    
public function intField($title, $name, $value='', $required=false, $id=null, $class=null, $attrs=array()){

	return $this->_addField(
		array_merge(array('type'=>'number', 'name'=>$name, 'title'=>$title, 'id'=>$id, 'class'=>$class, 'value'=>$value, 'placeholder'=>$title, 'required'=>$required),$attrs)
	);

}

public function checkBox($title, $name, $value=1, $checked=true, $id=null, $class=null, $attrs=array()){

	return $this->_addField(
		array_merge(array('type'=>'checkbox', 'name'=>$name, 'title'=>$title, 'id'=>$id, 'class'=>$class, 'value'=>$value, 'checked'=>$checked), $attrs)
	);

}
    
public function radio($title, $name, $value=1, $checked=true, $id=null, $class=null, $attrs=array()){

	return $this->_addField(
		array_merge(array('type'=>'radio', 'name'=>$name, 'title'=>$title, 'id'=>$id, 'class'=>$class, 'value'=>$value, 'checked'=>$checked), $attrs)
	);

}

public function selectField($title, $name, $value='', $required=false, $options=array(), $id=null, $class=null, $attrs=array()){

	return $this->_addField(
		array_merge(array('type'=>'select', 'name'=>$name, 'title'=>$title, 'id'=>$id, 'class'=>$class, 'value'=>$value, 'placeholder'=>$title, 'required'=>$required),$attrs),
		$options
	);

}

public function textArea($title, $name, $value='', $required=false, $id=null, $class=null, $w=null, $h=null, $attrs=array()){

	if($w || $h){
		if(isset($attrs['style']) && !empty($attrs['style'])){
			$attrs['style'] = preg_replace('~(width:[^;];|height:[^;];)~i', '', $attrs['style']);
			$attrs['style'] = trim($attrs['style'], ';').';';
		}else $attrs['style'] = '';
		if($w) $attrs['style'] .= 'width:'.(isdig($w)?$w.'px':$w).';';
		if($h) $attrs['style'] .= 'height:'.(isdig($h)?$h.'px':$h).';';
	}
	return $this->_addField(
		array_merge(array('type'=>'textarea', 'name'=>$name, 'title'=>$title, 'id'=>$id, 'class'=>$class, 'value'=>$value, 'placeholder'=>$title, 'required'=>$required),$attrs)
	);

}

public function branchSelect($title, $name, $value, $required=false, $tree=array(), $lockNid=false, $lockIid=false){

	$key = $this->_getNewKey();
	
	$this->formSructure['_items'][$key] = array(
		'_id' => $key,
		'_parent'=>$this->currentContext,
		'_'=>'branchsel',
		'_tpl'=>path($this->tpl_path, 'branchsel.tpl'),
		'_tpl_path'=>$this->tpl_path,
		'_tree'=>$tree,
		'_attr'=>array('value'=>$value, 'title'=>$title, 'name'=>$name)
	);
    if($lockNid) $this->formSructure['_items'][$key]['_attr']['data-lock-nid'] = $lockNid;
    if($lockIid) $this->formSructure['_items'][$key]['_attr']['data-lock-iid'] = $lockIid;

}
    
public function submitButton($title, $name, $value='', $id=null, $class=null, $attrs=array()){

	return $this->_addField(
		array_merge(array('type'=>'submit', 'name'=>$name, 'title'=>$title, 'id'=>$id, 'class'=>$class, 'value'=>$value),$attrs)
	);

}
    
public function button($title, $name, $value='', $id=null, $class=null, $attrs=array()){

	return $this->_addField(
		array_merge(array('type'=>'button', 'name'=>$name, 'title'=>$title, 'id'=>$id, 'class'=>$class, 'value'=>$value),$attrs)
	);

}
    
public function resetButton($title, $name, $value='', $id=null, $class=null, $attrs=array()){

	return $this->_addField(
		array_merge(array('type'=>'reset', 'name'=>$name, 'title'=>$title, 'id'=>$id, 'class'=>$class),$attrs)
	);

}
    
public function hidden($name, $value='', $id=null, $class=null, $attrs=array()){

	return $this->_addField(
		array_merge(array('type'=>'hidden', 'name'=>$name, 'id'=>$id, 'class'=>$class, 'value'=>$value),$attrs)
	);

}

public function getStructure(){

	return $this->formSructure;

}

public function assignStructureForTPL(){

	if(empty($this->formSructure)) return false;
	
//  print_r($this->formSructure);
	
	$nodes = new Nodes();
	$nodes->importFlat($this->formSructure['_items'], '_id', '_parent');
	
	$tpl = TPL::getInstance('core');
	$fld3D = $nodes->exportTree('_id', '_parent', '_items', true, false);
	$fld3D = array_merge($this->formSructure, array('_items' => $fld3D));
//	print_r($fld3D);
	$tpl->assign( 'form_data_' . $this->formSructure['id'], $fld3D );

}
	
}