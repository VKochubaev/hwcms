<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

interface iNodes {
	
	// Можем при инициализации класса сразу переключиться на определённую сохранённую в памяти структуру
	public function __construct($context=null);
	
	// Переключает на работу с определённой сохранённой структурой (текущая структура будет потеряна, если не была сохранена в банке)
	public function switchBank($context);
	
	// Загружаем узлы
	public function loadNodes($table=false, $cols=false, $entryId=null);
	
	// Чистит все сохранённые структуры
	public function clearBanks();
	
	// Вместе с созданием узла добавляем создаем ещё запись... $name - имя ресурса для записи; $opt - настройки
	public function nodeDataStorage($name, $opt);
	
	// Достаём узлы по критериям
	public function getNodes();
	
	// Добавление узла
	public function addNode($parent, $data=array());
	
	// Удаление узла
	public function removeNode($node_id);
	
	// Строим и отдаём многомерную структуру данных
	public function exportTree($id_key='id', $parent_key='parent', $nodes_key='nodes');
	
	// отдаём 2D структуру данных
	public function exportFlat($id_key='id', $parent_key='parent');

	// Импортирует многомерную структуру
	public function importTree($tree, $id_key='id', $parent_key='parent', $nodes_key='nodes');
	
	// Импортирует 2D структуру данных
	public function importFlat($flat, $id_key='id', $parent_key='parent');
	
}

?>