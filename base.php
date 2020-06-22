<?php

class DB{
  private $dsn="mysql:host=localhost;charset=utf8;dbname=db88";
  private $root="root";
  private $password="";
  private $table;
  private $pdo;

  public function __construct($table){
    $this->table=$table;
    $this->pdo=new PDO($this->dsn,$this->root,$this->password);
  }

    
    public function all(...$arg){
      $sql="select * from $this->table";
    
      if(!empty($arg[0]) && is_array($arg[0])) {
        foreach($arg[0] as $key => $value){
          $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
        $sql=$sql. " where " . join(" && ",$tmp);
      }

      if(!empty($arg[1])){
        $sql=$sql." ".$arg[1];
      }
      // echo $sql;
      return $this->pdo->query($sql)->fetchAll();
    }




    public function find($arg){
      $sql="select * from $this->table";
    
      if(is_array($arg)) {
        foreach($arg as $key => $value){
          $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
        $sql=$sql. " where " . join(" && ",$tmp);
      }else{
        $sql=$sql. "where `id`='$arg'";
      }
      // echo $sql;
      return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }




    public function count(...$arg){
      $sql="select count(*) from $this->table";
    
      if(!empty($arg[0]) && is_array($arg[0])){
        foreach($arg[0] as $key => $value){
          $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
        $sql=$sql. " where ". join(" && ",$tmp);
      }
      if(!empty($arg[1])){
        $sql=$sql. " ". $arg[1];
      }
      // echo $sql;
      return $this->pdo->query($sql)->fetchColumn();
    }




    public function save($arg){
      if(!empty($arg['id'])){
        //更新
        foreach($arg as $key => $value){
          if($key!='id'){
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
          }
        }
        $sql="update $this->table set ".join(",",$tmp)." where `id`='".$arg['id']."'";
      }else{
        //新增
        $sql="insert into $this->table (`".join("`,`",array_keys($arg))."`) values('".join("','",$arg)."')";
      }
      // echo $sql;
      return $this->pdo->exec($sql);
    }




    public function delete($arg){
      $sql="delete from $this->table";
    
      if(is_array($arg)) {
        foreach($arg as $key => $value){
          $tmp[]=sprintf("`%s`='%s'",$key,$value);
        }
        $sql=$sql. " where " . join(" && ",$tmp);
      }else{
        $sql=$sql. "where `id`='$arg'";
      }
      // echo $sql;
      return $this->pdo->exec($sql);
    }



    function q($sql){
     return $this->pdo->query($sql)->fetchAll();
    
    }

}





function to ($url){
  header("location:" .$url);
}




// ★判斷瀏覽人次

$total=new DB('total');
$chk=$total->find(['date'=>date("Y-m-d")]);

if(empty($chk) && empty($_SESSION['visited'])){
  //今日第一位訪客
  //頭香，需要新增今日資料。
  $total->save(['date'=>date("Y-m-d"),"total"=>1]);
  $_SESSOIN['visited']=1;

}else if(empty($chk) && !empty($_SESSION['visited'])){
  //沒有今天的資料，但有SESSION，1.手動更改日期，就是我們調整本機電腦的日期情況。2.23:59登入，過了一分鐘跨到隔天。
  //異常情形，需要新增今日資料。
  $total->save(['date'=>date("Y-m-d"),"total"=>1]);
  
}else if(!empty($chk) && empty($_SESSION['visited'])){
  // 表示是新來的，需要+1
  $chk['total']++;
  $total->save($chk);
  $_SESSOIN['visited']=1;

}/*else{
  // 有今天的資料，也有Session
  
}*/

//最一開始測試用:
// if(empty($_SESSION['visited'])){
  
//   if(empty($chk)){
//     //沒有今天的資料
//     $total->save(['date'=>date("Y-m-d"),'total'=>1]);
//   }else{
//     //有今天的資料
//     $chk['total']++;
//     $total->save($chk);
//   }
//   $_SESSION['visited']=1;
// }


?>