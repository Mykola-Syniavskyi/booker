<?php
include '../libs/restServer.php';
class Booker extends restServer
{

    protected $sortVuew;
    protected $email;
    protected $name;
    protected $role;
    protected $passwd;
    protected $confirmpasswd;
    protected $logEmail;
    protected $logPasswd;
    protected $user_id;
    protected $room;
    protected $startTime;
    protected $startDay;
    protected $endTime;
    protected $note;
    protected $recurent;
    protected $times;
    protected $duration;
    protected $createdDate;
    protected $event_id;
    protected $error;
    protected $curent_user_name;
    
  
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
    {   //return   $this->vuewRez($formData);              
        $tmpArr= array();
       if (sizeof($formData))
       {
           foreach ($formData as $key => $val)
           {
               if ($key =='name')
               {
                $this->name  = array($key => $val);
               }
               if ($key =='role')
               {
                $this->role  = array($key => $val);
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
           $role = $this->role['role'];
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
           
           if (strlen($name) >=3 && strlen($role) >=3)
           {
                $name = trim(htmlspecialchars($name));
                $role = trim(htmlspecialchars($role));
           }
           else 
           {
                return $this->vuewRez(array('error'=> COUNT_ERR_SYMBOL));
           }
           if (trim($passwd) === trim($confirmpasswd))
           {
                $dbh = new PDO(DSN, USER, PASSWD);
                $quer= "INSERT INTO b_users (name, role, email, password, status)values( '$name', '$role', '$email', '$passwd', 1)"; //print_r( $quer);
                //print_r($quer);
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
                $tmpArr = array($this->name, $this->role, $this->email, $this->passwd, $this->confirmpasswd);
                return $this->vuewRez($tmpArr);
                }
                else
                {
                    return $this->vuewRez(array('error'=>PASSWD_ERROR));
                }    
        }     
    }

    

    public function putLog($params)
    { 
        // return $this->vuewRez($params); 
        
        if (sizeof($params))
        {
             
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
            $quer = "SELECT id, name, password, role FROM b_users WHERE email = '$this->logEmail' AND password = '$this->logPasswd'"; //print_r($quer);
            foreach($dbh->query($quer) as $row) 
           { 
                $tmp_arr = array('name'=>$row['name'],'id'=>$row['id'] ,'password'=>$row['password'] ,'role'=>$row['role']);
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
    }



    public function postAddEvent($formdata)
    {   
        if (sizeof($formdata))
        {    
                
//CREATE LOCAL CREATED DATE FOR ADD EVENT  
               $this->createdDate = date('Y-m-d H:i:s');
               $created_data = $this->createdDate;
//GET VALUES FROM THE POST $FORMDATA
                $tmp_array = array('room','startDay','startTime','endTime','user_id','note','recurent','times','duration');//print_r($tmp_array);
                foreach ($formdata as $key=> $value)
                {
                    if (in_array($key, $tmp_array)) {
                        $this->$key= trim(htmlspecialchars($value));
                    }
                }
               
            
// CHECK FILDS FOR FILLING and PRAPARE DATA FOR ACTION WITH DATABASE
            if (empty($this->room))
            {
                return  $this->vuewRez(array('error'=>NO_ROOM));
            }
            else
            {
                $room = $this->room;
                $user_id = $this->user_id;
            }
            if (empty($this->startDay))
            {
                return  $this->vuewRez(array('error'=>NO_DATE));
            }
            else
            {
                $date = $this->startDay;
            }

            if (empty($this->startTime) || empty($this->endTime) || empty($this->note))
            {
                return  $this->vuewRez(array('error'=>NO_DATA_TIME_NOTE));
            }
            else
            {
                if ($this->startTime < $this->endTime)
                {
                    $time_1 = $this->startTime;
                    $time_2 = $this->endTime;
                }
                else
                {
                    return  $this->vuewRez(array('error'=>ERROR_TIME));
                }
                $note = $this->note;
            }

            if (null == $this->recurent)
            {
                return  $this->vuewRez(array('error'=>RECURENT_ERROR));
            }
//PREPARE INSERTED DATE            
            $dbh = new PDO(DSN, USER, PASSWD);
            $start =date( $date.' '.$time_1.':00'); //print_r($start."<br>"); CREATE DATE FOR INSERT
            $end = date($date.' '.$time_2.':00');//print_r($end);exit;  CREATE DATE FOR INSERT

//IN NOT RECURENT CASE
            if (false == (int)$this->recurent )
             {                
//CHECK DAY OF THE WEEK FOR FORBITTEN CHOOSING WEEKENDS
                if ($this->checkWeekDay($start))
                {   
//CHECK FREE SPACE IN THE BASE 
                    
                    if (!$this->checkDateEvent($start,$end, $room))
                    {
                       return $this->vuewRez(array('error'=>' _from '.$time_1.' to '.$time_2.'_ '. BUSY_TIME)); 
                    }//exit;

                    $quer = "INSERT INTO b_events (user_id, note, start, end, room_id, recurent_id, created_data )values('$user_id','$note','$start', '$end', '$room', NULL,'$created_data' )";
                    $sth = $dbh->prepare($quer);
                    $rez = $sth->execute();
                    if (true === $rez)
                    {
                        return $this->vuewRez(array('success'=> EDD_SUCCESS .$date.' _from '.$time_1.' to '.$time_2.'_' ));
                    }
                    else
                    {
                        return $this->vuewRez(array('error'=> EDD_ERROR));
                    }
                }return $this->vuewRez($this->error);
                
            }
// IN RECURENT CASE
            elseif ((int)$this->recurent &&  !empty($this->times) && !empty($this->duration))
            {   $recurent = $this->recurent;
                $times = $this->times;
                $duration = (int)$this->duration;

            switch ($times)
                {
//CASE 'WEEKLY':                    
                case 'WEEKLY':
               
                            for ($i =0; $i<= $duration; $i++)
                            {   
                                $a = strtotime($date."+$i week".$time_1.':00');
                                $b = strtotime($date."+$i week".$time_2.':00');
                                $start = date('Y-m-d h:i:s ',$a ); 
                                $end = date('Y-m-d h:i:s ',$b );
//CHECK DAY OFF  AND CROSS DATE IN DATABSE                               
                                if (!$this->checkDateEvent($start,$end, $room))
                                {
                                    return $this->vuewRez(array('error'=> ' _from '.$time_1.' to '.$time_2.'_ '. BUSY_TIME)); 
                                }
                                if (!$this->checkWeekDay($start))
                                {
                                    return $this->vuewRez($this->error);
                                }
                            }
//PUT FIRST ENTERING DATE
                                $start =date( $date.' '.$time_1.':00'); 
                                $end = date($date.' '.$time_2.':00');
//PARENT INSERT   EVENT                             
                                $quer = "INSERT INTO b_events (user_id, note, start, end, room_id, recurent_id, created_data )values('$user_id','$note','$start', '$end', '$room', null, '$created_data')";
                                $sth = $dbh->prepare($quer);
                                $rez = $sth->execute();
                                $id = $dbh->lastInsertId();//get last insert id

                                for($i = 1; $i<= $duration; $i++)
                                {
                                    $a = strtotime($date."+$i week".$time_1.':00');
                                    $b = strtotime($date."+$i week".$time_2.':00');
                                    $start = date('Y-m-d h:i:s ',$a ); 
                                    $end = date('Y-m-d h:i:s ',$b );
//CHILD INSERT EVENT   
                                    $quer = "INSERT INTO b_events (user_id, note, start, end, room_id, recurent_id, created_data )values('$user_id','$note','$start', '$end', '$room', $id, '$created_data')";
                                    $sth = $dbh->prepare($quer);
                                    $rez = $sth->execute();

                                }
                        
//CHECKING FOR ADDING EVENT
                            if (true === $rez)
                                {
                                    return $this->vuewRez(array('success'=> EDD_SUCCESS .$date.' _from '.$time_1.' to '.$time_2.'_'));
                                }
                                else
                                {
                                    return $this->vuewRez(array('error'=> EDD_ERROR));
                                }                       
                        break;
//CASE 'BI-WEEKLY':                         
                case 'BI-WEEKLY': 

                        for ($i =0; $i<= $duration; $i++)
                        {   
                            $i = $i*2;
                            $a = strtotime($date."+$i week".$time_1.':00');
                            $b = strtotime($date."+$i week".$time_2.':00');
                            $start = date('Y-m-d h:i:s ',$a ); 
                            $end = date('Y-m-d h:i:s ',$b );
                            if (!$this->checkDateEvent($start,$end, $room))
                            {
                                return $this->vuewRez(array('error'=> ' _from '.$time_1.' to '.$time_2.'_ '. BUSY_TIME)); 
                            }
                            if (!$this->checkWeekDay($start))
                            {
                                return $this->vuewRez($this->error);
                            }
                        }
//PUT FIRST ENTERING DATE
                            $start =date( $date.' '.$time_1.':00'); 
                            $end = date($date.' '.$time_2.':00');
//PARENT INSERT   EVENT          
                            $quer = "INSERT INTO b_events (user_id, note, start, end, room_id, recurent_id, created_data )values('$user_id','$note','$start', '$end', '$room', null, '$created_data')";
                            $sth = $dbh->prepare($quer);
                            $rez = $sth->execute();
                            $id = $dbh->lastInsertId();//get last insert id

                            for($i = 1; $i<= $duration; $i++)
                            {
                                $i = $i*2;
                                $a = strtotime($date."+$i week".$time_1.':00');
                                $b = strtotime($date."+$i week".$time_2.':00');
                                $start = date('Y-m-d h:i:s ',$a ); 
                                $end = date('Y-m-d h:i:s ',$b );
//CHILD INSERT   EVENT
                                $quer = "INSERT INTO b_events (user_id, note, start, end, room_id, recurent_id, created_data )values('$user_id','$note','$start', '$end', '$room', $id, '$created_data')";
                                $sth = $dbh->prepare($quer);
                                $rez = $sth->execute();

                            }

//CHECKING FOR ADDING EVENT
                        if (true === $rez)
                            {
                                return $this->vuewRez(array('success'=>EDD_SUCCESS .$date.' _from '.$time_1.' to '.$time_2.'_'));
                            }
                            else
                            {
                                return $this->vuewRez(array('error'=> EDD_ERROR));
                            }
                        break;

//CASE 'MONTHLY':                        
                case 'MONTHLY':

                        for ($i =0; $i<= $duration; $i++)
                        {   
                            $a = strtotime($date."+$i month".$time_1.':00');
                            $b = strtotime($date."+$i month".$time_2.':00');
                            $start = date('Y-m-d h:i:s ',$a ); 
                            $end = date('Y-m-d h:i:s ',$b );
//CHECK DAY OFF  AND CROSS DATE IN DATABSE                               
                            if (!$this->checkDateEvent($start,$end, $room))
                            {
                                return $this->vuewRez(array('error'=> ' _from '.$time_1.' to '.$time_2.'_ '. BUSY_TIME)); 
                            }
                            if (!$this->checkWeekDay($start))
                            {
                                return $this->vuewRez($this->error);
                            }
                        }
//PUT FIRST ENTERING DATE
                            $start =date( $date.' '.$time_1.':00'); 
                            $end = date($date.' '.$time_2.':00');
//PARENT INSERT   EVENT                             
                            $quer = "INSERT INTO b_events (user_id, note, start, end, room_id, recurent_id, created_data )values('$user_id','$note','$start', '$end', '$room', null, '$created_data')";
                            $sth = $dbh->prepare($quer);
                            $rez = $sth->execute();
                            $id = $dbh->lastInsertId();//get last insert id

                            for($i = 1; $i<= $duration; $i++)
                            {
                                $a = strtotime($date."+$i month".$time_1.':00');
                                $b = strtotime($date."+$i month".$time_2.':00');
                                $start = date('Y-m-d h:i:s ',$a ); 
                                $end = date('Y-m-d h:i:s ',$b );
//CHILD INSERT EVENT   
                                $quer = "INSERT INTO b_events (user_id, note, start, end, room_id, recurent_id, created_data )values('$user_id','$note','$start', '$end', '$room', $id, '$created_data')";
                                $sth = $dbh->prepare($quer);
                                $rez = $sth->execute();

                            }
                    
//CHECKING FOR ADDING EVENT
                        if (true === $rez)
                            {
                                return $this->vuewRez(array('success'=> EDD_SUCCESS .$date.'  _from '.$time_1.' to '.$time_2.'_'
                            ));
                            }
                            else
                            {
                                return $this->vuewRez(array('error'=> EDD_ERROR));
                            }  
                        break;
                }       
            }
            else
            {
                return  $this->vuewRez(array('error'=>EMPTY_FILDS_TIMES_DURATION));
            } 
    }
    else 
        {   
            return $this->vuewRez(array('error'=>NO_DATA));       
        }    
    }
        


//CHECK DAY OF THE WEEK FOR FORBITTEN CHOOSING WEEKENDS
    public function checkWeekDay($start)
    {
        
        $today = getdate(strtotime($start));
        $weekDay = $today['weekday'];
        if ($weekDay == 'Saturday' || $weekDay == 'Sunday' )
        {
            $this->error = (array('error'=> ERR_WEEKEND));
        }
        else 
        {
            return true;
        }
    }
      
    
//CHECK DATE IN THE DATABASE
    public function checkDateEvent($startTime,$endTime, $room_id)
        {
            $q = "select count(id) from b_events WHERE " . 
                " ('$startTime' < end and '$endTime' > start) AND" 
                 . 
                " room_id=$room_id  "; 
                $dbh = new PDO(DSN, USER, PASSWD);
                $stmt = $dbh ->prepare($q);
                $stmt->execute();
                $res = $stmt->fetchAll();
            

            if (0 == $res[0]['count(id)'])
            {
                return 1;//if it was not found cross return true
            }
            else
            {
                return 0;
            }           
        }


//GETT ALL EMPLOYEE

        public function getAllEmployee()
        {
            $dbh = new PDO(DSN, USER, PASSWD);
            $q = "SELECT id, name, email  from b_users";
            $dbh->prepare($q);
            $arr = array();
            foreach($dbh->query($q) as $row) 
           { 
                $tmp_arr = array('id'=>$row['id'],'name'=>$row['name'], 'email'=>$row['email'] );
                array_push($arr, $tmp_arr); 
           } 
           if (sizeof($arr))
           {
                return $this->vuewRez($arr); 
           }
           else
           {
                return  $this->vuewRez(array('error'=>ERROR_USERS)); 
           }    
        }


        public function puteditEmployee($formData)
        {
            //  return  $this->vuewRez($formData);

            
            $tmp_array = array('user_id','name','role','email','passwd');//print_r($tmp_array);
                foreach ($formData as $key=> $value)
                {
                    if (in_array($key, $tmp_array)) {
                        $this->$key= trim(htmlspecialchars($value));
                    }
                }

                if (strlen($this->name) == 0 || strlen($this->email) == 0 || strlen($this->passwd) == 0)
                {
                    return $this->vuewRez(array('error'=> 'PLEASE fill all filds!'));

                }

                if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
                {
                    return $this->vuewRez(array('error'=>ERR_EMAIL));
                }

                if ( $this->role !='user' && $this->role !='admin' )
                {
                    return $this->vuewRez(array('error'=> 'enter only USER or ADMIN'));
                }
            $passwd = md5($this->passwd);
            $dbh = new PDO(DSN, USER, PASSWD);
            $sql = "UPDATE `b_users`   
                SET `name` = :name,
                    `email` = :email,
                    `password` = :password,
                    `role` = :role 
                WHERE `id` = :user_id";
            $statement = $dbh->prepare($sql);
            $statement->bindValue(":name", $this->name);
            $statement->bindValue(":email", $this->email);
            $statement->bindValue(":password", $passwd);
            $statement->bindValue(":role", $this->role);
            $statement->bindValue(":user_id", $this->user_id);
            $rez = $statement->execute();
           
            if (true === $rez)
            {
                return $this->vuewRez(array('success'=> DATA_UPDATED   ));
            }
            else
            {
                return $this->vuewRez(array('error'=> ERROR_UPDATE));
            } 
        }




        public function deleteEmployee($id)
        {   
            if (strlen($id) > 0)
            {
                $id = trim(htmlspecialchars($id));
                $dbh = new PDO(DSN, USER, PASSWD);
                $sql = "DELETE FROM b_users WHERE id = :id" ;
                $statement = $dbh->prepare($sql);
                $statement->bindValue(":id", $id);
                $rez = $statement->execute();
           
                if (true === $rez)
                {
                    return $this->vuewRez(array('success'=> SUCCESS_DELETE_USER   ));
                }
                else
                {
                    return $this->vuewRez(array('error'=> ERROR_DELETE_USER));
                } 
            }
            else
            {
                return $this->vuewRez(array('error'=> ERROR_USER));
            }
   
        }



        public function getAllEvents($date, $room_id, $year)
        {    
            if (strlen($date) > 0)
            // return $this->vuewRez($room_id);
            $date = trim(htmlspecialchars($date));
            $dbh = new PDO(DSN, USER, PASSWD);
            $sql = "SELECT b_events.id, b_events.user_id, b_events.note, b_events.start, b_events.end, b_events.room_id, b_events.recurent_id, b_events.created_data, b_users.name  FROM b_events   LEFT JOIN b_users ON user_id = b_users.id where month(start) = $date  and room_id = $room_id  and YEAR(start) = $year" ;
            {  
                $arr = array();
                foreach($dbh->query($sql) as $row) 
                { 
                        $tmp_arr = array('id'=>$row['id'],'user_id'=>$row['user_id'],'note'=>$row['note'],'start'=>$row['start'],'end'=>$row['end'],'room_id'=>$row['room_id'],'recurent_id'=>$row['recurent_id'],'created_data'=>$row['created_data'], 'name'=>$row['name'] );
                        array_push($arr, $tmp_arr); 
                } 
                
                if (sizeof($arr))
                {

                    return $this->vuewRez($arr); 
                }else {
                    return false;
                }
            }
        }



        public function putEventUpdate($data)
        {
            // return $this->vuewRez($data);
            if (sizeof($data))
            {  
                //  return $this->vuewRez($data);          
                $tmp_array = array('event_id','startTime','endTime','note','recurent','user_id','role','name', 'curent_user_name');//print_r($tmp_array);
                foreach ($data as $key=> $value)
                {
                    if (in_array($key, $tmp_array)) 
                    {
                        $this->$key= trim(htmlspecialchars($value));
                    }
                }
                // CHECKING TIME
                if ($this->startTime > $this->endTime )
                {
                    return $this->vuewRez(array('error'=> ERROR_TIME   )); 
                }

                $dbh = new PDO(DSN, USER, PASSWD);

//GET TIME FROM DATABASE FOR CHANGE
                $sql="SELECT start, end, recurent_id, room_id  FROM b_events where id = $this->event_id";
                $arr = array();
                foreach($dbh->query($sql) as $row) 
                { 
                        $tmp_arr = array('start'=>$row['start'],'end'=>$row['end'], 'recurent_id'=>$row['recurent_id'], 'room_id'=>$row['room_id']);
                        array_push($arr, $tmp_arr); 
                } 

                $partTimeFirst = substr($arr[0]['start'],0,10);
                $start = $partTimeFirst.' '.$this->startTime.':00';
                $end = $partTimeFirst.' '.$this->endTime.':00';
                $recurent_id = $arr[0]['recurent_id'];
                $room_id = $arr[0]['room_id'];

                //CHECK USER FOR UPDATing ONLY PERSONAL EVENT
//NOT RECURENT

                if ($this->role == 'user' && ($this->recurent == NULL || $this->recurent == 0) )
                { 
                    if (!$this->checkDateEvent($start, $end, $room_id))
                        {
                            return $this->vuewRez(array('error'=> ' _from '.$this->startTime.' to '.$this->endTime.'_ '. BUSY_TIME)); 
                        }
                    $sql = "UPDATE b_events   
                    SET b_events.start = :start,
                        b_events.end = :end,
                        b_events.note = :note
                    WHERE b_events.id = '$this->event_id' AND b_events.user_id =  (SELECT id FROM b_users where name = :name )";
                    $statement = $dbh->prepare($sql);
                    $statement->bindValue(":start", $start);
                    $statement->bindValue(":end", $end);
                    $statement->bindValue(":note", $this->note);
                    $statement->bindValue(":name", $this->curent_user_name);
                    // $statement->bindValue(":event_id", $this->event_id);
                      
                    $statement->execute();
                    $count =  $statement->rowCount();
                    // print_r($count);exit;
                    if ($count > 0)
                    {
                        return $this->vuewRez(array('success'=> DATA_UPDATED   ));
                    }
                    else
                    {
                        return $this->vuewRez(array('error'=> ERROR_UPDATE_USER));
                    } 
                }
//FOR RECURENT EVENT
                elseif ($this->role == 'user' && 1 == $this->recurent )
                {   
                    $sql = " SELECT recurent_id from b_events where  id = $this->event_id AND b_events.user_id =  (SELECT id FROM b_users where name = '$this->curent_user_name' )";
                    // print_r($sql);exit;
//GET RECURENT ID FOR RECURSIVE UPDATE
                    foreach($dbh->query($sql) as $row) 
                    {
                        $recurent_id_recursive = $row['recurent_id'];
                    }
                    if ($recurent_id_recursive == NULL)
                    {
                        return $this->vuewRez(array('error'=> ERROR_UPDATE_USER));
                    } 
                    // print_r($recurent_id_recursive)  ;exit;                 

//SELECT RECURSIVE EVENTS
                    
                    $sql = " SELECT id , start, end, note from  b_events where  (id ='$recurent_id_recursive' or  recurent_id = '$recurent_id_recursive') AND b_events.user_id =  (SELECT id FROM b_users where name = '$this->curent_user_name' );";//было просто имя 
                    $arr = array();
                    //  print_r($sql);exit;
                    foreach($dbh->query($sql) as $row) 
                    { 
                        $tmp_arr = array('start'=>$row['start'],'end'=>$row['end'],'note'=>$row['note'],'id'=>$row['id']);
                        array_push($arr, $tmp_arr); 
                    }
// PICK UP TIME FROM BASE and CHECK IT
                    foreach ($arr as $key => $value)
                    {   
//GET ONLY DATE
                        $start_date = substr($value['start'],0,10).' '.$this->startTime.':00';
                        $end_date = substr($value['start'],0,10).' '.$this->endTime.':00';
                        // print_r($room_id);exit;
                        if (!$this->checkDateEvent($start_date, $end_date, $room_id))
                            {
                                return $this->vuewRez(array('error'=> ' _from '.$this->startTime.' to '.$this->endTime.'_ '. BUSY_TIME)); 
                            }
                    }

                    foreach ($arr as $key => $value)
                    {   
//GET ONLY DATE
                        $start_date = substr($value['start'],0,10).' '.$this->startTime.':00';
                        $end_date = substr($value['start'],0,10).' '.$this->endTime.':00';

                        $sql = "UPDATE b_events   
                        SET b_events.start = '$start_date',
                        b_events.end = '$end_date',
                        b_events.note = '$this->note'
                        WHERE b_events.id = '$value[id]'";
                        // print_r($sql);
                        $statement = $dbh->prepare($sql);
                        $statement->execute();
                        $count =  $statement->rowCount();
                    } 
                    if ($count > 0)
                    {
                        return $this->vuewRez(array('success'=> DATA_UPDATED));
                    }
                    else
                    {
                        return $this->vuewRez(array('error'=> ERROR_UPDATE_USER));
                    } 
                }
// UPDATE FOR ADMIN NOT RECURENT EVENTS             
                elseif ($this->role == 'admin' && ($this->recurent == NULL || $this->recurent == 0  )) 
                { 
                    if (!$this->checkDateEvent($start, $end, $room_id))
                        {
                            return $this->vuewRez(array('error'=> ' _from '.$this->startTime.' to '.$this->endTime.'_ '. BUSY_TIME)); 
                        }
                    $sql = "UPDATE b_events   
                    SET b_events.start = :start,
                        b_events.end = :end,
                        b_events.note = :note
                    WHERE b_events.id = '$this->event_id' AND b_events.user_id =  (SELECT id FROM b_users where name = :name )";
                    $statement = $dbh->prepare($sql);
                    $statement->bindValue(":start", $start);
                    $statement->bindValue(":end", $end);
                    $statement->bindValue(":note", $this->note);
                    $statement->bindValue(":name", $this->name);
                    // $statement->bindValue(":event_id", $this->event_id);
                      
                    $statement->execute();
                    $count =  $statement->rowCount();
                    // print_r($count);exit;
                    if ($count > 0)
                    {
                        return $this->vuewRez(array('success'=> DATA_UPDATED   ));
                    }
                    else
                    {
                        $this->vuewRez(array('error'=>'this event was not created by this user  , please choose another user'));
                    } 
                }
//UPDATE FOR ADMIN RECURENT EVENTS
                elseif($this->role == 'admin' && $this->recurent == 1)
                {
                    $sql = " SELECT recurent_id from b_events where  id = $this->event_id AND b_events.user_id =  (SELECT id FROM b_users where name = '$this->name' )";
                    // print_r($this->name);exit;
//GET RECURENT ID FOR RECURSIVE UPDATE
                    foreach($dbh->query($sql) as $row) 
                    {
                        $recurent_id_recursive = $row['recurent_id'];
                    }
                    if ($recurent_id_recursive == NULL)
                    {
                        return  $this->vuewRez(array('error'=>'this event was not created by this user , please choose another user'));
                    }
//SELECT RECURSIVE EVENTS
                    $sql = " SELECT id , start, end, note from  b_events where  (id ='$recurent_id_recursive' or  recurent_id = '$recurent_id_recursive') AND b_events.user_id =  (SELECT id FROM b_users where name = '$this->name' );";
                    $arr = array();
                    foreach($dbh->query($sql) as $row) 
                    { 
                        $tmp_arr = array('start'=>$row['start'],'end'=>$row['end'],'note'=>$row['note'],'id'=>$row['id']);
                        array_push($arr, $tmp_arr); 
                    }//print_r($arr);exit;
// PICK UP TIME FROM BASE and CHECK IT
                    foreach ($arr as $key => $value)
                    {   
//GET ONLY DATE
                        $start_date = substr($value['start'],0,10).' '.$this->startTime.':00';
                        $end_date = substr($value['start'],0,10).' '.$this->endTime.':00';
                        if (!$this->checkDateEvent($start_date, $end_date, $room_id))
                            {
                                return $this->vuewRez(array('error'=> ' _from '.$this->startTime.' to '.$this->endTime.'_ '. BUSY_TIME)); 
                            }
                    }

                    foreach ($arr as $key => $value)
                    {   
//GET ONLY DATE
                        $start_date = substr($value['start'],0,10).' '.$this->startTime.':00';
                        $end_date = substr($value['start'],0,10).' '.$this->endTime.':00';

                        $sql = "UPDATE b_events   
                        SET b_events.start = '$start_date',
                        b_events.end = '$end_date',
                        b_events.note = '$this->note'
                        WHERE b_events.id = '$value[id]'";
                        // print_r($sql);
                        $statement = $dbh->prepare($sql);
                        $statement->execute();
                        $count =  $statement->rowCount();
                    } 
                    if ($count > 0)
                    {
                        return $this->vuewRez(array('success'=> DATA_UPDATED));
                    }
                    else
                    {
                        return $this->vuewRez(array('error'=> ERROR_UPDATE_USER));
                    } 
    

                    
                }
                else 
                {
                    return $this->vuewRez(array('error'=>EDD_ERROR));
                }
            }


            
        }

        
        public function deleteEventDelete($id , $role, $recurent, $curent_user_name)
        {
            //  return $this->vuewRez(array('error'=> $recurent));
            if (strlen($id) > 0)
            {   $this->role = trim(htmlspecialchars($role));
                $id = trim(htmlspecialchars($id));
                $this->recurent = trim(htmlspecialchars($recurent));
                $this->curent_user_name = trim(htmlspecialchars($curent_user_name));

                $dbh = new PDO(DSN, USER, PASSWD);

                if($this->role == 'user' && ($this->recurent == 0 || $this->recurent == NULL) )
                {
                    $sql = "DELETE FROM b_events WHERE b_events.id = '$id' AND b_events.user_id =  (SELECT id FROM b_users where name =  '$this->curent_user_name' )";
                    $statement = $dbh->prepare($sql);
                    $statement->execute();
                    $count =  $statement->rowCount();
                    if ($count > 0)
                    {
                        return $this->vuewRez(array('success'=> SUCCESS_DELETE_EVENT   ));
                    }
                    else
                    {
                        return $this->vuewRez(array('error'=> ERROR_DELETE_EVENT));
                    } 
                }

                elseif($this->role == 'user' && $this->recurent == 1 )
                {
                    $sql = "SELECT  id  FROM b_events where id = $id or id =  (select recurent_id from b_events where id = $id);";
                    $arr = array();
                    foreach($dbh->query($sql) as $row) 
                    { 
                            $tmp_arr = array('id'=>$row['id']);
                            array_push($arr, $tmp_arr); 
                    } 

                    foreach ($arr as $key=> $value)
                    {
                        $sql = "DELETE FROM b_events WHERE b_events.id = '$value[id]' AND b_events.user_id =  (SELECT id FROM b_users where name =  '$this->curent_user_name' )";
                        $statement = $dbh->prepare($sql);
                        $statement->execute();
                    }

                    $count =  $statement->rowCount();
                    if ($count > 0)
                    {
                        return $this->vuewRez(array('success'=> SUCCESS_DELETE_EVENT   ));
                    }
                    else
                    {
                        return $this->vuewRez(array('error'=> ERROR_DELETE_EVENT));
                    } 
                }


                elseif ($this->role == 'admin' && ($this->recurent == NULL || $this->recurent == 0  )) 
                { 
                    $sql = "SELECT b_events.id FROM b_events left join  b_users on b_events.user_id =  b_users.id WHERE b_events.id = $id;";
                    $arr = array();
                    foreach($dbh->query($sql) as $row) 
                    { 
                            $tmp_arr = array('id'=>$row['id']);
                            array_push($arr, $tmp_arr); 
                    }
                    $deleteed_id = $arr[0]['id'];

//DELETE NO RECURENT
                    $sql = "DELETE FROM b_events WHERE b_events.id = '$deleteed_id'";
                    $statement = $dbh->prepare($sql);
                    $statement->execute();
                    $count = $statement->rowCount();
                    if ($count > 0)
                    {
                        return $this->vuewRez(array('success'=> SUCCESS_DELETE_EVENT   ));
                    }
                    else
                    {
                        $this->vuewRez(array('error'=>'this event was not deleted, plase reload page'));
                    } 
                }



                elseif ($this->role == 'admin' && $this->recurent == 1) 
                { 
//GET NAME USER EVENT
                    $sql = "SELECT b_users.name FROM b_events left join  b_users on b_events.user_id =  b_users.id WHERE b_events.id = $id;";
                    $arr = array();
                    foreach($dbh->query($sql) as $row) 
                    { 
                        $tmp_arr = array('name'=>$row['name']);
                        array_push($arr, $tmp_arr); 
                    }
                    $this->name = $arr[0]['name'];

                    $sql = "SELECT  id  FROM b_events where id = $id or id =  (select recurent_id from b_events where id = $id);";
                    $arr = array();
                    foreach($dbh->query($sql) as $row) 
                    { 
                            $tmp_arr = array('id'=>$row['id']);
                            array_push($arr, $tmp_arr); 
                    } 

                    foreach ($arr as $key=> $value)
                    {
                        $sql = "DELETE FROM b_events WHERE b_events.id = '$value[id]' AND b_events.user_id =  (SELECT id FROM b_users where name =  '$this->name' )";
                        $statement = $dbh->prepare($sql);
                        $statement->execute();
                        $count =  $statement->rowCount();
                    }

                    if ($count > 0)
                    {
                        return $this->vuewRez(array('success'=> SUCCESS_DELETE_EVENT   ));
                    }
                    else
                    {
                        return $this->vuewRez(array('error'=> ERROR_DELETE_EVENT));
                    } 
                }
                

            }else 
            {
                return $this->vuewRez(array('error'=> 'no $id'));
            }
        }
        
}
$obj = new Booker();
$obj->parsUrl();
$obj->getMethod();
