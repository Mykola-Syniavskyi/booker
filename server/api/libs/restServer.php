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
    { //print_r($_SERVER['REQUEST_URI']);
       if  ($_SERVER['REQUEST_URI'])
       {
           $arrMethod= array();
           $arrParams= array();
           $this->url= $_SERVER['REQUEST_URI'];  
            // $arrRez = explode('/',$this->nameMethod= substr($this->url, 37));//for classes
            $arrRez = explode('/',$this->nameMethod= substr($this->url, 25));//for home
            $this->method = $_SERVER['REQUEST_METHOD'];
            foreach ($arrRez as $key=>$val)
            {
                if ($key==0)
                {
                    array_push($arrMethod, $val); 
                    $this->nameMethod = $arrMethod[0];
                }
                if ($key==1)
                {
                     array_push($arrParams, $val);
                     $this->params = $arrParams;
                }
            
                //   print_r($this->params[0]);
             }
            //    print_r( $this->nameMethod);
             $this->getSortVuew();
       }
    }
    
    public function getMethod()
      {  //print_r($this->method);
                switch($this->method)
        {   
            case 'GET':
            //echo  123;
                $this->setMethod('get'.ucfirst($this->nameMethod), $this->params[0]);
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
