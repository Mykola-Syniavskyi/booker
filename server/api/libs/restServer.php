<?php
include 'config.php';
class restServer
{
    protected $url;
    protected $method ;
    protected $params;
    protected $nameMethod;
    protected $errors = array();
    
    public function parsUrl()
    { //print_r($_SERVER['REQUEST_URI']."<br>");
       if  ($_SERVER['REQUEST_URI'])
       {
           $arrMethod= array();
           $arrParams= array();
           $this->url= $_SERVER['REQUEST_URI'];  
            // $arrRez = explode('/',$this->nameMethod= substr($this->url, 34));//for classes
            $arrRez = explode('/',$this->nameMethod = substr($this->url, 26));//for home
            
        //    print_r($arrRez);
           
            $this->method = $_SERVER['REQUEST_METHOD'];
            foreach ($arrRez as $key=>$val)
            { //var_dump($arrRez);
                if ($key===0)
                { //print_r($arrRez);
                    array_push($arrMethod, $val); 
                    $this->nameMethod = $arrMethod[0]; //print_r($this->nameMethod);
                }
                 if ($key===1)
                {
                    array_push($arrParams, $val);
                    $this->params = $arrParams[0];
                }
            
                    // print_r($this->params);
             }
                // print_r( $this->nameMethod);exit;
             $this->getSortVuew();
       }
    }
    
    public function getMethod()
      {  //print_r($this->method);
        header("Access-Control-Allow-Origin: http://localhost:8080");
        header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, DELETE, PATCH');
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type,token, Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
        header("Access-Control-Expose-Headers: Location");
                switch($this->method)
        {   
            case 'GET':
            // echo  123;
                $this->setMethod('get'.ucfirst($this->nameMethod), $this->params);
                break;
            case 'DELETE':
                $this->setMethod('delete'.ucfirst($this->nameMethod), $this->params[0]);
                break;
            case 'POST':
            
                $this->params = '';
                $this->params  = $_POST;
                $this->setMethod('post'.ucfirst($this->nameMethod), $this->params);
                break;
            case 'PUT':
                parse_str(file_get_contents('php://input'), $params);
                $this->params  = $params; //print_r($fParams);
                $this->setMethod('put'.ucfirst($this->nameMethod), $this->params);
                break;
            default:
                return false;
        }
    }
    
    // public function Test($param)
    // {
    //     echo "hello, $param";
    // }
    function setMethod($method, $param=false)
    { 
         
        if (method_exists($this, $method))
        { 
            call_user_func(array($this, $method) ,$param );
        }
        else
        {
            header("HTTP/1.1 400 Bad Request Api");
            $this->errors = '404 Sorry, we cant find this action!';
        }
    }
    public function getErrors()
    {
        if (!empty($this->errors))
        {
            return $this->errors;
        }
    }
    
    
}
