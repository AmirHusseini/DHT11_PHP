<?php

//Read the data using get and push them to the database 
if($_GET['humidity'] != '' and $_GET['temperature'] != ''){
 $dht11=new dht11($_GET['humidity'],$_GET['temperature']);
}

class dht11{
 public $link='';
 function __construct($humidity, $temperature){
  $this->connect();
  $this->storeInDB($humidity, $temperature);
 }
 
 // connect and select the database
 function connect(){
  $this->link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'test') or die('Cannot select the DB');
 }
 
 //store the coming data from arduino to the database 
 function storeInDB($humidity, $temperature){
  $query = "insert into dht11 set humidity='".$humidity."', temperature='".$temperature."'";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}



?>
