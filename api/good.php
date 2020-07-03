<?php
include_once "../base.php";

$New=new DB("news");
$Log=new DB("log");

$id=$_POST['id'];
$type=$_POST['type'];
$user=$_POST['user'];
$post=$News->find($id);

switch($type){
  case 1:
    $Log->save(['news'=>$id,'user'=>$user]);
    $post['good']++;
    $News->save($post);
  break;
  case 2:
    $Log->delete(['news'=>$id,'user'=>$user]);
    $post['good']--;
    $News->save($post);
  break;
}


?>