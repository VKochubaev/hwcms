<?php

if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

/*

Работа с древовидными структурами данных

*/

class Nodes {

static private $storedNodes = array();

public $nodes = array();
private $context = null;
private $tmp_nodes = null;
private $node_indexes = array();
private $entry_id_col = null;
private $entries_table = null;

// Можем при инициализации класса сразу переключиться на определённую сохранённую в памяти структуру
public function __construct($context=null){

	if($context !== null && !empty($context)){
        
		$this->switchBank($context);
        
	}

}

private function __clone(){}

// Переключает на работу с определённой сохранённой струкрурой (текущая структура будит потеряна, если не была сохранена в банке)
public function switchBank($context){
	
	if(empty($context)) throw new Exception('Не указан контекст дерева!');
    if(!isset(self::$storedNodes[$context]) || !is_array(self::$storedNodes[$context])) self::$storedNodes[$context] = array();
        
    $this->context = $context;

    if(!isset(self::$storedNodes[$context]['nodes'])) self::$storedNodes[$context]['nodes'] = array();
    $this->nodes = &self::$storedNodes[$context]['nodes'];

    if(!isset(self::$storedNodes[$context]['nodes'])) self::$storedNodes[$context]['nodes'] = null;
    $this->tmp_nodes = &self::$storedNodes[$context]['tmp_nodes'];

    if(!isset(self::$storedNodes[$context]['node_indexes'])) self::$storedNodes[$context]['node_indexes'] = array();
    $this->node_indexes = &self::$storedNodes[$context]['node_indexes'];

    if(!isset(self::$storedNodes[$context]['entry_id_col'])) self::$storedNodes[$context]['entry_id_col'] = null;
    $this->entry_id_col = &self::$storedNodes[$context]['entry_id_col'];

    if(!isset(self::$storedNodes[$context]['entries_table'])) self::$storedNodes[$context]['entries_table'] = null;
    $this->entries_table = &self::$storedNodes[$context]['entries_table'];

    return true;

}

// Чистит все сохранённые структуры
public function clearBanks(){

	$banksName = func_get_args();
    if(func_num_args() > 0){
        foreach($banksName as $bName){
            unset(self::$storedNodes[$bName]);
        }
    }else self::$storedNodes = array();

}

// Загружаем узлы
public function loadNodes($table=false, $cols=false, $entryId=null, $where=array()){

    $this->_setEntryId($entryId);
    if($table) $this->entries_table = $table;
    
    // Подключаем БД и грузим ноды
	$db = DB::getInstance('core');
	
    $cols_ins = '';
    $where[] = "n.`context`=?";
	
	if($table && $cols && is_array($cols)){
	
		foreach($cols as $kcol=>$vcol){
		
			$cols_ins[] = !is_int($kcol) ? "a.`$kcol` AS `$vcol`" : "a.`$vcol`";
		
		}
		$cols_ins = (sizeof($cols_ins) == 0) ? 'a.*' : ', '.join(', ', $cols_ins);
		$where[] = "a.`node_id`=n.`node_id`";
		
	}
	
    $q = "SELECT n.`node_id` AS _node_id, n.`parent_id` AS _parent_id, n.`node_path` AS _node_path, n.`node_ord` AS _node_ord$cols_ins ".
		"FROM ( `nodes` n".($table ? ", `$table` a " : '').") ".
		(sizeof($where)>0 ? "WHERE ".join(" AND ", $where) : '').
		//"ORDER BY n.`parent_id` ASC, n.`node_id` ASC, n.`node_ord` ASC";
		" ORDER BY n.`parent_id` ASC, n.`node_ord` ASC";

	$q = $db->query($q, array($this->context), 'assoc');
	if($q){

        $this->tmp_nodes = null;
		return ($this->importFlat($q, '_node_id', '_parent_id', null, false)) ? true : false;
        
	}
	return false;

 }

// Достаём узлы по id
public function getNodes($node_id, $return_mode=0 /* 0 - nodes, 1 - indexes, 2 - both*/){

    if(isdig($node_id)) $node_id = array($node_id);
    elseif(!is_array($node_id)) return false;
    array_walk($node_id, 'intval');
    $return_mode = intval($return_mode);
    
    $retNodes = array();
    foreach($this->nodes as &$node){
     
        $idx = false;
        switch(@$return_mode){
            case 0: default:
                if(in_array($node['id'], $node_id)) $retNodes[] = &$node;
            break;
            case 1:
                $idx = array_search($node['id'], $node_id, false);
                if($idx !== false) $retNodes[] = $idx;
            break;
            case 2:
                $idx = array_search($node['id'], $node_id, false);
                if($idx !== false) $retNodes[] = array('i'=>$idx, 'n'=>&$node);
            break;            
        }
        
    }
    unset($node);
    return $retNodes;

}
    
public function getNode($node_id, $return_mode=0){
    
    if(!isdig($node_id)) return false;
    $node = $this->getNodes($node_id, $return_mode);
    return ($node && sizeof($node)==1) ? $node[0] : false;
    
}

// Достаём всех родителей узла в виде дерева
public function getAllChildrenTree($node_id, $separate_data = true){
    
    if(!isdig($node_id)) return false;
    $way = $this->getBranchToId(intval($node_id));
    $tree = $this->exportTree('_id', '_parent', '_nodes', true, $separate_data);
    $curLevelNode = &$tree;
    foreach($way as &$wayItem){
    
        if($wayItem['id'] == 0) continue;
        if(isset($curLevelNode[$wayItem['id']]) && $curLevelNode[$wayItem['id']]['_id'] == $wayItem['id']){
            
            if(isset($curLevelNode[$wayItem['id']]['_nodes']) && sizeof($curLevelNode[$wayItem['id']]['_nodes']) > 0){
                
                $curLevelNode = &$curLevelNode[$wayItem['id']]['_nodes'];
                
            }else{
                
                $curLevelNode = array();
                break;
                
            }
            
        }
        
    }
    unset($wayItem);    
    return $curLevelNode;
    
}
    
// Достаём всех родителей узла в виде плосского массива
public function getAllChildrenFlat($node_id, $separate_data = true){
 
    return $this->convertTreeToFlat( $this->getAllChildrenTree($node_id, $separate_data), '_nodes' );
    
}
    
// Добавление узла
public function addNode($parent_id, $data=array()){

	if(is_int($parent_id)){
	
		if(end($this->nodes)){
			$new_id = key($this->nodes) + 1; 
		}else $new_id = 0;
		$this->nodes[$new_id] = array(
			'id' => $new_id,
			'parent' => $parent_id||0,
			'data' => $data||array()
		);
		return $new_id;
	}
	return false;

}

// Вместе с созданием узла добавляем создаем ещё запись... $name - имя ресурса для записи; $opt - настройки
public function nodeDataStorage($name, $opt){

// test

}
    
// Удаление узла
public function removeNode($node_id, $on_success=null){

    if(!isdig($node_id)) return false;
    
    $targetNode = $this->getNode($node_id, 2);

    if($targetNode){
    
        $useDb = (is_string($this->entries_table) && !empty($this->entries_table)) ? true : false;
        $childrenNodes = $this->getAllChildrenFlat($node_id, false);
        $numOfChildren = sizeof($childrenNodes);
        
        if($numOfChildren > 0){

            foreach($childrenNodes as &$cNode) $cNode = $cNode['_id'];
            $childrenNodes = $this->getNodes($childrenNodes, 2);

        }
        if($useDb){
            
            $db = DB::getInstance();
            $db->transactionBegin();
            
        }
        
        $deleted = false;
        $deletedChields = array();
        $deletedIdx = array();
        $errors = array();
        $mainSuccess = true;
        
        try{
        
            if(!isset($this->nodes[$targetNode['i']])){
                
                $mainSuccess = false;
                
            }else{

                if($mainSuccess && $useDb && isset($targetNode['n']['id']) && isdig($targetNode['n']['id'])){

                    $mainDel = $db->query("DELETE a, n FROM (?t a, `nodes` n) WHERE n.`node_id`=?i AND a.`node_id`=n.`node_id`", array($this->entries_table, $targetNode['n']['id']), 'ar');
                    if($mainDel === false || $mainDel < 1) $mainSuccess = false;

                }
                if($mainSuccess){

                    $deleted = $targetNode['n']['id'];
                    $deletedIdx[] = $targetNode['i'];
                    if(!is_null($on_success) && is_callable($on_success)){

                        $on_success(
                            $targetNode['n']['id'],
                            $targetNode['n'],
                            (!is_string($this->entry_id_col) && !empty($this->entry_id_col) && $useDb && isset($targetNode['n']['data'][$this->entry_id_col])) ? $targetNode['n']['data'][$this->entry_id_col] : null
                        );

                    }

                }

            }
            if(!$mainSuccess) $errors[] = $targetNode['n']['id'];

            if($mainSuccess && $numOfChildren > 0) {

                foreach($childrenNodes as &$cNode){

                    $localSuccess = true;
                    if(!isset($this->nodes[$cNode['i']])){
                        
                        $localSuccess = false;
                        
                    }else{

                        if($localSuccess && $useDb && isset($targetNode['n']['id']) && is_int($targetNode['n']['id'])){

                            $mainDel = $db->query("DELETE a, n FROM (?t a, `nodes` n) WHERE n.`node_id`=?i AND a.`node_id`=n.`node_id`", array($this->entries_table,$cNode['n']['id']), 'ar');
                            if($mainDel === false || $mainDel < 2){
                                
                                $localSuccess = false;
                                
                            }

                        }

                        if($localSuccess){

                            $deletedChields[] = $cNode['n']['id'];
                            $deletedIdx[] = $cNode['i'];
                            if(!is_null($on_success) && is_callable($on_success)){

                                $on_success(
                                    $cNode['n']['id'],
                                    $cNode['n'],
                                    (!is_string($this->entry_id_col) && !empty($this->entry_id_col) && $useDb && isset($cNode['n']['data'][$this->entry_id_col])) ? $cNode['n']['data'][$this->entry_id_col] : null
                                );

                            }

                        }

                    }
                    if(!$localSuccess) $errors[] = $cNode['n']['id'];

                }

            }
            
        }
        catch(goDBQuery $e){
         
            $mainSuccess = false;
            
        }
      
        if($mainSuccess){
            
            if(sizeof($deletedIdx)>0){
             
                sort($deletedIdx);
                foreach($deletedIdx as $idx) unset($this->nodes[$idx]);
                
            }
            if($useDb) $db->transactionCommit();
            return array('deleted'=>$deleted, 'deletedChields'=>$deletedChields, 'errors'=>$errors);
            
        }
        
    }
    if($useDb) $db->transactionRollback();

    return false;

}

// Убрать ноду и её потомков из набора, не удаляя из БД
public function subtractNode($node_id, $on_success=null){
    
    if(!isdig($node_id)) return false;
    $node_id = intval($node_id);
    
    if($node = $this->getNode($node_id)){
        
        $nodesToSubtract = array($node_id);
        $childrenOfNode = $this->getAllChildrenFlat($node_id);
        
        if(sizeof($childrenOfNode) > 0){
            
            foreach($childrenOfNode as &$cn){
                
                $nodesToSubtract[] = $cn['_id'];
                
            }
        
        }
        
        unset($childrenOfNode, $cn);
        $nodesToSubtract = array_flip(array_reverse($nodesToSubtract));
        $complete = 0;
        
        foreach($this->nodes as $ni=>&$n){

            if(isset($nodesToSubtract[$n['id']])){ unset($this->nodes[$ni]); $complete++; }

        }
        return sizeof($nodesToSubtract) == $complete ? $complete : false;
        
    }else return false;
    
}
    
// Опререляем путь от корня до целевого узла
public function getBranchToId($trgid=null, $i=0){

	if($trgid===null || !isdig($trgid)) return false;
	if(!$this->nodes && sizeof($this->nodes)==0) return false;
	static $way = array();
	
	if($trgid > 0){
	
		foreach($this->nodes as &$node){

			if($node['id'] == $trgid){
				$way[] = $node;
				if(isset($node['parent'])) $this->getBranchToId($node['parent'], $i+1);
				break;
			}
		
		}
        unset($node);
	
	}
	if($i==0){
	
		$way[] = array('id'=>0,'parent'=>0);
		return array_reverse($way);
		
	}

}

// Получение id узла по id записи связанной с узлом
public function getNodeIdByEntryId ($eid, $entryId=null){
 
    if(!isdig($eid) && !is_array($eid)) return false;
    if(!is_array($eid)) $eid = array($eid);
    array_walk($eid, 'intval');
    $eidCnt = $eidCntTmp = sizeof($eid);
    $this->_setEntryId($entryId);
    if(is_string($this->entry_id_col)){
        
        $nid = array();
        foreach($this->nodes as &$tmpN){
            
           if(in_array($tmpN['data'][$this->entry_id_col], $eid)){
               
               $nid[intval($tmpN['data'][$this->entry_id_col])] = intval($tmpN['id']);
               if($eidCntTmp <= 0) break;
               --$eidCntTmp;
               
           }
            
        }
        unset($tmpN);
        return $eidCnt==1 ? @reset($nid) : $nid;
        
    }
    return false;
    
}
    
// Получение id записи по id узла
public function getEntryIdByNodeId ($nid, $entryId=null){
 
    if(!isdig($nid) && !is_array($nid)) return false;
    if(!is_array($nid)) $nid = array($nid);
    array_walk($nid, 'intval');
    $nidCnt = $nidCntTmp = sizeof($nid);
    $this->_setEntryId($entryId);
    if(is_string($this->entry_id_col)){
        
        $eid = array();
        foreach($this->nodes as &$tmpN){

           if(in_array($tmpN['id'], $nid)){
               echo $tmpN['id']."\n";
               $eid[intval($tmpN['id'])] = intval($tmpN['data'][$this->entry_id_col]);
               if($nidCntTmp <= 0) break;
               --$nidCntTmp;
               
           }
            
        }
        unset($tmpN);
        return $nidCnt==1 ? @reset($eid) : $eid;
        
    }
    return false;
    
}
    
// Строим и отдаём многомерную структуру данных
public function exportTree($id_key='id', $parent_key='parent', $nodes_key='nodes', $ret_from_root=false, $separate_data = true){

	$tree = array(0=>array($id_key=>0, $parent_key=>0));
	$temp = array(0=>&$tree[0]);
 
	foreach ($this->nodes as $val) {
        
		if( !$separate_data ){
		
			$val2 = array_merge(
				$val['data'],
				array(
					$id_key => $val['id'],
					$parent_key => $val['parent']
				)
			);
			
		}
        else{
		
			$val2 = array(
				$id_key => $val['id'],
				$parent_key => $val['parent'],
				'data' => $val['data']
			);
		
		}

		$parent = &$temp[ $val2[$parent_key] ];
		if (!isset($parent[$nodes_key])) {
            
			$parent[$nodes_key] = array();
            
		}
		$parent[$nodes_key][$val2[$id_key]] = $val2;
		$temp[$val2[$id_key]] = &$parent[$nodes_key][$val2[$id_key]];
        
	}
	unset($temp, $val, $parent);
	
	return ($ret_from_root == true) ? isset($tree[0][$nodes_key]) ? $tree[0][$nodes_key] : array() : $tree;

}
	
// Отдаём 2D структуру данных
public function exportFlat($id_key='id', $parent_key='parent', $ret_from_root=false, $separate_data=true, $build_helpers=true){

    return $this->convertTreeToFlat( $this->exportTree($id_key, $parent_key, '__nodes__', $ret_from_root, $separate_data), '__nodes__', $id_key, $build_helpers );

}

public function convertTreeToFlat($t, $in_node_key, $in_id_key=null, $build_helpers=true, $level=1, $way=array()){

    if(!is_array($t)) return false;
    
    static $flat = array();
    static $i = 0;
    $ii = 1;
    $cnt = sizeof($t);
    foreach($t as $tk=>&$nitem){

        $flat[$i] = $nitem;
        if($build_helpers === true){

            $flat[$i]['_first'] = ($ii == 1) ? true : false;
            $flat[$i]['_last'] = ($ii == $cnt) ? true : false;
            $flat[$i]['_has_childs'] = intval(@sizeof($nitem[$in_node_key]));
            $flat[$i]['_level'] = $level;
            if(!is_null($in_id_key)) $flat[$i]['_way'] = array_merge($way, array($flat[$i][$in_id_key]));

        }
        unset($flat[$i][$in_node_key]);
        $i++;
        
        if(isset($nitem[$in_node_key]) && is_array($nitem[$in_node_key])){

            $this->convertTreeToFlat( $nitem[$in_node_key], $in_node_key, $in_id_key, $build_helpers, $level+1, !is_null($in_id_key) ? array_merge($way, array($nitem[$in_id_key])) : array() );

        }
        $ii++;

    }
    unset($nitem);

    return $flat;

}

// Импортирует многомерную структуру
public function importTree($tree, $id_key='id', $parent_key='parent', $nodes_key='nodes'){



}

// Импортирует 2D структуру данных
public function importFlat($flat, $id_key='id', $parent_key='parent', $ord_key=null, $force_sort=true){

	if(!empty($flat) && is_array($flat)){
		
		$this->nodes = array();
        $this->tmp_nodes = null;
        $this->node_indexes = array();
	
/*		if($force_sort){
            
			eval('usort($flat, function($a, $b){
						$i=0;
						if(!isset($a["'.$id_key.'"]) || !isset($b["'.$id_key.'"])) return $i;
						if(strlen($a["'.$id_key.'"]) < strlen($b["'.$id_key.'"])) $i--;
						if(strlen($a["'.$id_key.'"]) > strlen($b["'.$id_key.'"])) $i++;
						if($a["'.$id_key.'"] < $b["'.$id_key.'"]) $i--;
						if($a["'.$id_key.'"] > $b["'.$id_key.'"]) $i++;'.(
						$ord_key && !empty($ord_key) ?
						'if(isset($a["'.$ord_key.'"]) && isset($b["'.$ord_key.'"])){
							if($a["'.$ord_key.'"] < $b["'.$ord_key.'"]) $i--;
							if($a["'.$ord_key.'"] > $b["'.$ord_key.'"]) $i++;
						}':''
						).'return $i; 
					});');
            
		}*/

		$i = 0;
		foreach($flat as $fk=>$f){

            $id = intval($f[$id_key]);
			$parent = intval($f[$parent_key]);
			$ord = intval(@$f[($ord_key ? $ord_key : '_node_ord')]);
            $this->node_indexes[$id] = $parent;
			unset($f[$id_key], $f[$parent_key]);
			$this->nodes[] = array(
				'id' => $id,
				'parent' => $parent,
				'ord' => $ord,
				'data' => $f
			);
			$i++;
			unset($flat[$fk]);
            
		}
		unset($flat); 
		
		return $i;

	}
	return false;

}
    
private function _setEntryId($entryId){
 
	if(is_string($entryId) && !empty($entryId)){
     
        $this->entry_id_col = $entryId;
        if(!is_null($this->context)) self::$storedNodes[$this->context]['entry_id_col'] = $this->entry_id_col;
        return true;
        
    }
    return false;
    
}
    
// Отладка
public function debug(){
	
	print_r($this->nodes);
	
}

}

?>