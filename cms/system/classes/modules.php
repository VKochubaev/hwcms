<?php

class Modules {

static $classCache = array();
    
static public function getClass(){
 
    $a = func_get_args();
    $la = func_num_args();
    
    if(!$a || !isset($a[0]) || empty($a[0])) throw new Exception('Plugin name not set!');
    
    $constructArgs = array();
    
    if($la > 2){
        
        $className = $a[1];
        $moduleName = $a[0];
        unset($a[0]);
        if(is_array($a[2])) $constructArgs = $a[2];
        
    }else{
        
        $className = $a[0];
        $moduleName = $className;
        unset($a[0]);
        if(is_array($a[1])) $constructArgs = $a[1];
        
    }
    
    $classHash = $moduleName.'|'.$className;
    
    if(isset(static::$classCache[$classHash]) && isset(static::$classCache[$classHash]['fpath']) && isset(static::$classCache[$classHash]['module']) && isset(static::$classCache[$classHash]['class']))
    {
     
/*        if(!class_exists($className, false)){
            
            include_once path(modPath, $moduleName, 'classes', $className.'.php');
        
        }
*/
        
        if(class_exists($className, false)){

            return new $className($constructArgs);

        }else throw new Exception('Promissed class '.$className.' not found!');
        
    }else{
     
        $classPath = path(modPath, $moduleName, 'classes', $className.'.php');

        if(!file_exists($classPath)) throw new Exception('Class '.$className.' file not found!');
        else{
            
            if(!class_exists($className, false)){

                include_once $classPath;

            }

            if(class_exists($className, false)){

                if($object = new $className($constructArgs)){
                 
                    static::$classCache[$classHash] = array(
                        'fpath' => $classPath,
                        'module' => $moduleName,
                        'class' => $className
                    );
                    return $object;
                    
                }

            }else throw new Exception('Class '.$className.' not found!');
            
        }
        
    }
    
    
}
    
}

?>