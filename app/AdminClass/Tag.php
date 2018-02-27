<?php
namespace  App\AdminClass;
class Tag{
  public $tag ='url';//имя тега
  public $data="Date"; //вложенные данные
  public $type='_S_';//or _D_
  public $tags=array();//вложенные теги
  public $attr=array();//список аттрибутов
  public $is_line=0;// без закрытия
  //Для тега без данных

  //Для тега без данных
  public function __construct($name, $data=NULL){

      $this->tag=$name;
      if ($data!=NULL){
        $this->data=$data;
        $this->type='_S_';
      }else{
          $this->type='_D_';
      }

  }


  public function addTaginTag($newTag){
    $this->tags[]=$newTag;
  }
  public function printTag(){
      $answ='';
      $answ=$answ.$this->openTag();
    if($this->type=='_S_'){

        $answ=$answ. $this->data;

    }else{
        for($i=0;$i<count($this->tags);$i++){
            $answ=$answ.$this->tags[$i]->printTag();
        }
    }
    if($this->is_line==1){

    }
    else{
        $answ=$answ.$this->closeTag();
    }
        return $answ;
  }
  public function addAttr($key,$value){
      if(array_key_exists($key, $this->attr)){
        echo 'Error. This Key is using!';
      }
      else{
        $this->attr[$key]=$value;
      }
  }
  /*open tag and add atributes in tag*/
  public function openTag(){
    $list_attr='';

    foreach ($this->attr as $key => $value) {
      $list_attr=$list_attr.' '.$key.'="'.$value.'"';
    }
    if($this->is_line==1){
          return '<'.$this->tag.' '.$list_attr.'/>';
    }
    else{
          return '<'.$this->tag.' '.$list_attr.'>';
    }

  }
  public function closeTag(){
    return '</'.$this->tag.'>';
  }
}

