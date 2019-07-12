<?php
include '../libs/restServer.php';
class carShop extends restServer
{
    protected $sortVuew;
    protected $arrayAllCars;
    protected $arrayOneCar;
    protected $email;
    protected $name;
    protected $lastname;
    protected $passwd;
    protected $confirmpasswd;
    protected $PayUserId;
    protected $paymentsType;
    protected $PayCarId;
    protected $brand;
    protected $color;
    protected $engine_capacity;
    protected $max_speed;
    protected $model;
    protected $price;
    protected $year;
    protected $logEmail;
    protected $logPasswd;
    protected $userId;// for show order
    protected $testUser;
    
    

    function getTest(){
        $resultArray = array();
        $dbh = new PDO(DSN, USER, PASSWD);
        foreach($dbh->query("select * from test") as $row) 
        {
            $tmp_array = array('id'=>$row['id'],'name'=>$row['name']);
            array_push($resultArray, $tmp_array); 
        }
       $this->testUser = $resultArray;
       $this->vuewRez($this->testUser, $this->sortVuew);
        return $resultArray;
    }

    function getAllCars()
    { //print_r('fff');
        $resultArray = array();
        $dbh = new PDO(DSN, USER, PASSWD);// print_r($dbh);
        foreach($dbh->query("select cars.id, brand.brand, model.model  from cars join brand on cars.id=brand.id join   model on cars.id=model.id") as $row) 
        {
            $tmp_array = array('id'=>$row['id'],'brand'=>$row['brand'],'model'=>$row['model']);
            array_push($resultArray, $tmp_array); 
        }
       $this->arrayAllCars = $resultArray;
       $this->vuewRez($this->arrayAllCars, $this->sortVuew);
        return $resultArray;
    }
    function getOneCar($id)
    {
        $resultArray = array();
        $dbh = new PDO(DSN, USER, PASSWD);
        $stmt = $dbh->prepare("select cars.id, cars.engine_capacity,cars.max_speed,cars.price,cars.year, model.model, color.color  from cars  join   model on cars.id=model.id join color_cars on color_cars.car_id=cars.id join color on color.id=color_cars.color_id   where cars.id =?");
        $stmt->execute([$id]); 
        $row = $stmt->fetch();
            $tmp_arr = array(
            'id' => $row['id'],
            'model'=>$row['model'],    
            'engine_capacity'=>$row['engine_capacity'],
            'year'=>$row['year'],
            'color'=>$row['color'],
            'max_speed'=>$row['max_speed'],
            'price'=>$row['price']);
             array_push($resultArray, $tmp_arr); 
             $this->arrayOneCar = $resultArray;
            $this->vuewRez($this->arrayOneCar, $this->sortVuew);
        return $resultArray;
        
       
    }
    public function getSortVuew()
    {
        $id = substr($this->url, strrpos($this->url, '/') + 1);
        //$id = explode('?', $id)[0];
        $this->sortVuew = $id; //print_r($this->sortVuew);
        // return $this->sortVuew;
    }
    private function vuewRez($result, $sortVuew = 'json')
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: text/html; charset=utf-8'); 
        header('Cache-Control: no-cache');
        if (!$result)
        {
            header("HTTP/1.1 400 Bad Request Api");
            $result = '404 Sorry, we cant find this action!';
        }
         
 
        //ставим заголовок
        switch ($sortVuew) {
            case '.txt':
           //echo "HELLO PHP";
                header('Content-type: text/plain');
                echo "<pre>";
                print_r($result);
                echo "</pre>";
                break;
            case '.html':
                header('Content-type: text/html'); //print_r($result);//die();
                if ($this->arrayAllCars)
                {
                    $counter = 0;
                    $counter = count($result); 
                    $i=0;
                    while ( $i < $counter )
                    {
                        foreach ($result[$i++] as $key=>$val)
                        {
                            echo "<pre>". $key . " : " . $val . "; ";
                        }
                    }
                }else
                {            
                    foreach ($result[0] as $key=>$val) 
                    { 
                        echo "<pre>". $key  ." : ". $val . "; ";   
                    }
                }  
                break;
            case '.xml':
                header('Content-type: application/xml');
                echo $this->toXml($result);
                break;
            default:
                header('Content-Type: application/json');
                echo json_encode($result);
                break;
        }
    }
    public function toXml($result)
    {   
        $xml = new SimpleXMLElement('<root/>');
        foreach ($result as $key =>$val)
        {  $result = array_flip($val); 
           array_walk_recursive($result, array ($xml, 'addChild'));
        }//die();
      
        print $xml->asXML();
    }
    
    public function getHelp()
    {
         print_r( get_class_methods($this));
    }


    public function postReg($formData)
    {
        $tmpArr= array();
       if (sizeof($formData))
       {
           foreach ($formData as $key => $val)
           {
               if ($key =='name')
               {
                $this->name  = array($key => $val);
               }
               if ($key =='last_name')
               {
                $this->lastname  = array($key => $val);
               }
               if ($key =='email')
               {
                $this->email  = array($key => $val);
             
               }
               if ($key =='passwd')
               {
                $this->passwd  = array($key => $val);
               
               }
               if ($key =='confirm_passwd')
               {
                $this->confirmpasswd  = array($key => $val);         
               }  
            }
           $name = $this->name['name'];
           $lastname = $this->lastname['last_name'];
           $email =$this->email['email'];
           
           //check email
           if (filter_var($email, FILTER_VALIDATE_EMAIL))
           {
                $email = trim(htmlspecialchars($email));
           }
           else
           {
                return $this->vuewRez(array('error'=>ERR_EMAIL));
           }
           
           $passwd = $this->passwd['passwd'];
           
           //check parol for length
           if (strlen($passwd) >=4)
           {
                $passwd = md5(htmlspecialchars(trim($passwd)));
           }
           else
           {
                return $this->vuewRez(array('error'=>COUNT_ERR_SYMBOL_PASSWD));
           }
           $confirmpasswd = md5(trim(htmlspecialchars($this->confirmpasswd['confirm_passwd'])));
           
           if (strlen($name) >=3 && strlen($lastname) >=3)
           {
                $name = trim(htmlspecialchars($name));
                $lastname = trim(htmlspecialchars($lastname));
           }
           else 
           {
                return $this->vuewRez(array('error'=> COUNT_ERR_SYMBOL));
           }
           if (trim($passwd) === trim($confirmpasswd))
           {
                $dbh = new PDO(DSN, USER, PASSWD);
                $quer= "INSERT INTO users (name, lastname, email,  password)values( '$name', '$lastname', '$email', '$passwd' )"; //print_r( $quer);
                $stmt = $dbh->prepare($quer);//die('hello');
                $rez=$stmt->execute(); //var_dump($rez);
                if (true === $rez)
                {
                    return $this->vuewRez(array('success'=> REGISTER_SUCCESS));
                }
                else 
                {
                    return $this->vuewRez(array('error'=> 'sorry, you entered exists email !'));
                }
                $tmpArr = array($this->name, $this->lastname, $this->email, $this->passwd, $this->confirmpasswd);
                return $this->vuewRez($tmpArr);
                }
                else
                {
                    return $this->vuewRez(array('error'=>PASSWD_ERROR));
                }    
        }     
    }

    

    public function putLog($params)
    {   if (sizeof($params))
        {
            // return $this->vuewRez($arr);
            foreach ($params as $key=> $value)
            {
                if ($key == 'email')
                {
                    $this->logEmail = trim(htmlspecialchars($value));
                }
                if ($key == 'passwd')
                {
                    $this->logPasswd = md5(htmlspecialchars(trim($value)));
                }
            }
            //return  $this->vuewRez(array(1=>$this->logPasswd));
            $arr = array();
            $dbh = new PDO(DSN, USER, PASSWD);
            $quer = "SELECT id, name, lastname, password FROM users WHERE email = '$this->logEmail' AND password = '$this->logPasswd'"; //print_r($quer);
            foreach($dbh->query($quer) as $row) 
           { 
                $tmp_arr = array('name'=>$row['name'],'lastname'=>$row['lastname'],'id'=>$row['id'] ,'password'=>$row['password']);
                array_push($arr, $tmp_arr); 
           } 
           if (sizeof($arr))
           {
               return $this->vuewRez($arr); 
           }
           else 
           {
                return $this->vuewRez(array('error'=>LOGFORM));
           }
           
        }
        else
        {
            return $this->vuewRez(array('error'=> FORM));
        }
       //return $this->vuewRez($params);
    }



    public function postBuy($formData)
    {
        if (sizeof($formData))

        { //return $this->vuewRez($formData);
            foreach ($formData as $key => $value)
            {
               if ($key == 'user_id')
               {
                    $this->PayUserId = $value;
               }
               
               if ($key == 'payments')
               {
                $this->paymentsType = $value;
               }
               if ($key == 'car_id')
               {
                $this->PayCarId = $value;
               }
            }
 
            if (!empty($this->paymentsType))
            {
                $this->paymentsType = trim(htmlspecialchars($this->paymentsType));
            }
            else 
            {
                return $this->vuewRez(array('error'=> PAY_ERROR));
            }


            //return $this->vuewRez(array('firstname' =>"$this->payName"));
            $dbh = new PDO(DSN, USER, PASSWD);
            $quer = "INSERT INTO orders (car_id, payments, user_id)values(:car_id,:payments,:user_id)";
            $sth = $dbh->prepare($quer);
            //return $this->vuewRez([$typePay, $lastname, $firstname]);
            $sth->bindParam(':car_id',$this->PayCarId,PDO::PARAM_INT);
            $sth->bindParam(':payments',$this->paymentsType,PDO::PARAM_STR);
            $sth->bindParam(':user_id',$this->PayUserId,PDO::PARAM_INT);
            $rez = $sth->execute(); 
            if (true === $rez)
            {
                return $this->vuewRez(array('success'=> BUY_SUCCESS));
            }
            else
            {
                return $this->vuewRez(array('error'=> BUY_ERROR));
            }
 
            //return $this->vuewRez($formData);
        }
        else
        {
            return $this->vuewRez(array('error'=>'no data'));
        }
        
    }
    


    public function postfindCarByParams($params)
    {//print_r($params);
        if (isset($params) && !empty($params))
        {
            foreach ($params as $key => $value)
            {
                if ($key == 'brand')
                {
                    $this->brand = trim(htmlspecialchars($value));
                }
                if ($key == 'color')
                {
                    $this->color = trim(htmlspecialchars($value));
                }
                if ($key == 'engine_capacity')
                {
                    $this->engine_capacity = trim(htmlspecialchars($value));
                }
                if ($key == 'max_speed')
                {
                    $this->max_speed = trim(htmlspecialchars($value));
                }
                if ($key == 'model')
                {
                    $this->model = trim(htmlspecialchars($value));
                }
                if ($key == 'price')
                {
                    $this->price = trim(htmlspecialchars($value));
                }
                if ($key == 'year')
                {
                    $this->year = trim(htmlspecialchars($value));
                }
            }

            //check for entered date
            if (!empty($this->year))
            {
                $this->year = trim(htmlspecialchars($this->year));
            }
            else
            {
                return $this->vuewRez(array('error'=>YEAR));
            }
            
            //  return $this->vuewRez(array('year'=>$this->year));
            // return $this->vuewRez($params);
            $arr = array();
            $dbh = new PDO(DSN, USER, PASSWD);
            $quer= " SELECT cars.id, cars.engine_capacity,cars.max_speed,cars.price,cars.year, model.model, color.color, brand.brand  from cars  join   model on cars.id=model.id join color_cars on color_cars.car_id=cars.id join color on color.id=color_cars.color_id join brand on brand.id=cars.id   WHERE cars.year= $this->year " . $this->addEngine_capacity() . $this->addMax_speed() . $this->addModel() . $this->addBrand() . $this->addPrice() . $this->addColor();
           //print_r(" SELECT cars.id, cars.engine_capacity,cars.max_speed,cars.price,cars.year, model.model, color.color, brand.brand  from cars  join   model on cars.id=model.id join color_cars on color_cars.car_id=cars.id join color on color.id=color_cars.color_id join brand on brand.id=cars.id   WHERE cars.year= $this->year " . $this->addEngine_capacity() .  $this->addMax_speed() . $this->addModel() . $this->addBrand() . $this->addPrice() . $this->addColor());
            foreach($dbh->query($quer) as $row) 
           { 
                $tmp_arr = array('id'=>$row['id'],'model'=>$row['model'], 'engine_capacity'=>$row['engine_capacity'],'year'=>$row['year'] , 'color'=>$row['color'], 'max_speed'=>$row['max_speed'], 'brand'=>$row['brand'], 'price'=>$row['price']  );
                array_push($arr, $tmp_arr); 
           } 
           if (sizeof($arr))
           {
                return $this->vuewRez($arr); 
           }
           else
           {
                return  $this->vuewRez(array('error'=>SEARCH_PARAMS)); 
           }    
    }
}


    public function addEngine_capacity()
    {
        if ($this->engine_capacity)
        {
            return " and engine_capacity= $this->engine_capacity ";
        }
        else 
        {
            return ' ';
        }
    }


    public function addMax_speed()
    {
        if ($this->max_speed)
        {
            return " and max_speed= $this->max_speed ";
        }
        else 
        {
            return ' ';
        }
    }


    public function addModel()
    {
        if ($this->model)
        {
            return " and model= '$this->model' ";
        }
        else 
        {
            return ' ';
        }
    }


    public function addBrand()
    {
        if ($this->brand)
        {
            return " and brand= '$this->brand' ";
        }
        else 
        {
            return ' ';
        }
    }


    public function addPrice()
    {
        if ($this->price)
        {
            return " and price= '$this->price' ";
        }
        else 
        {
            return ' ';
        }
    }


    public function addColor()
    {
        if ($this->color)
        {
            return " and color= '$this->color' ";
        }
        else 
        {
            return ' ';
        }
    }


    public function postShowOrder($userId)
    {   //var_dump($userId);
        if (sizeof($userId))
        {
            $this->userId = (int)trim(htmlspecialchars($userId['user_id']));
            $arr = array();
            $dbh = new PDO(DSN, USER, PASSWD);
            $quer = "SELECT cars.engine_capacity,cars.max_speed,cars.price,cars.year, model.model, color.color, brand.brand,orders.payments, orders.id as order_id, users.name,users.lastname, users.email  from cars  join   model on cars.id=model.id join color_cars on color_cars.car_id=cars.id join color on color.id=color_cars.color_id join brand on brand.id=cars.id join orders on orders.car_id = cars.id join users on orders.user_id = users.id where orders.user_id= $this->userId;";
            // $quer = "SELECT cars.id, cars.engine_capacity,cars.max_speed,cars.price,cars.year, model.model, color.color, brand.brand,orders.payments, orders.id as order_id, users.name,users.lastname, users.email  from cars  join   model on cars.id=model.id join color_cars on color_cars.car_id=cars.id join color on color.id=color_cars.color_id join brand on brand.id=cars.id join orders on orders.car_id = cars.id join users on orders.user_id = users.id where orders.user_id= $this->userId;";
            $dbh->query($quer); 
            
            foreach($dbh->query($quer) as $row) 
           { //print_r($row);exit;
                $tmp_arr = array('name'=>$row['name'], 'lastname'=>$row['lastname'], 'email'=>$row['email'],'order_id'=>$row['order_id'],'brand'=>$row['brand'], 'model'=>$row['model'],'engine_capacity'=>$row['engine_capacity'], 'max_speed'=>$row['max_speed'], 'year'=>$row['year'] , 'color'=>$row['color'],  'price'=>$row['price']  );
                array_push($arr, $tmp_arr); 
           } 
           if (sizeof($arr))
           {
            return $this->vuewRez($arr);
           }
           else 
           {
               return $this->vuewRez(array('error'=>'you have nothing !')); 
           }

        }
        else
        {
            return $this->vuewRez(array('error'=>'something was went wrong, we are fixing it !'));
        }
        
    }   
}
$obj = new carShop();
$obj->parsUrl();

// $obj->postReg($formData);
// $obj->setMethod('Test', "Vasia");
$obj->getMethod();
//echo $obj->getErrors();
//echo 'hello world';