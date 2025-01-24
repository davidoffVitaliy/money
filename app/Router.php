<?php


function getUri()
{
    return $result = trim($_SERVER['REQUEST_URI'], '/');
    //return $_SERVER['REQUEST_URI'];
    //return substr($result, 7);
}


function Router()
{
    $routes = routes();
    $getUri = getUri();
    
    //
    foreach($routes as $uriPatern=>$path){
        
        if(preg_match("~$uriPatern~", $getUri, $matches)){
            $preg = preg_replace("~$uriPatern~", $path, $getUri);
           
            
            $array = explode('/', $preg);   
        
        
            $ac = array_shift($array);

            $param = array_shift($array);
            
            $action = $ac.'Controller';
            
        
            return $action($param);
            if($action != null){
            break;
            }
        }
}
}






