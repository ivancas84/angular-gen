<?php

require_once("generate/GenerateFileEntity.php");


class GenCardHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-card.component.html";
    if(!$directorio) $directorio = PATH_GEN . "tmp/component/card/" . $entity->getName("xx-yy") . "-card/";
    parent::__construct($directorio, $file, $entity);
  }


  public function generateCode() {
    $this->start();
    $this->nf();
    $this->fk();
    //$this->options();
    $this->end();
  }


  protected function start(){
    $this->string .= "<div *ngIf=\"data$ | async as data\" class=\"card\">
  <div class=\"card-header\">
    {$this->entity->getName('Xx Yy')} {{data.id | label:\"{$this->entity->getName()}\"}}
  </div>

  <div class=\"card-body\">
    <dl class=\"row\">
";
  }

  protected function nf(){
    foreach ($this->getEntity()->getFieldsNf() as $field) {
      if($field->isHidden()) continue; //se omiten los campos de agregacion
      
      $this->string .= "      <dt class=\"col-sm-3\">{$field->getName('Xx Yy')}</dt>
      <dd class=\"col-sm-9\">" ;
      switch($field->getSubtype()){
        case "checkbox": $this->checkbox($field); break;
        case "date": $this->date($field); break;
        //case "timestamp": $this->timestamp($field); break;
        //case "time": $this->time($field); break;
        default: $this->defecto($field); break;
      }
      $this->string .= "</dd>

";
    }
  }

  protected function fk(){
    foreach ($this->getEntity()->getFieldsFk() as $field) {
      if($field->isHidden()) continue; //se omiten los campos de agregacion
      
      $this->string .= "      <dt class=\"col-sm-3\">{$field->getName('Xx Yy')}</dt>
      <dd class=\"col-sm-9\"><a [routerLink]=\"['/" . $field->getEntityRef()->getName("xx-yy") . "-detail']\" [queryParams]=\"{id:data." . $field->getName() . "}\" >{{data." . $field->getName() . " | label:'{$field->getEntityRef()->getName()}'}}</a></dd>

";
    }
  }

  protected function end(){
    $this->string .= "    </dl>
  </div>
</div>
";
  }














  protected function defecto(Field $field){
    $this->string .= "{{data." . $field->getName() . "}}";
  }



  protected function textarea(Field $field){
    $this->string .= "<span title=\"{{data." . $field->getName() . "}}\">{{data." . $field->getName() . " | summary}}</span>";
  }

  protected function date(Field $field){
    $this->string .= "{{data." . $field->getName() . " | toDate | date:'dd/MM/yyyy'}}";
  }

  protected function checkbox(Field $field){
    $this->string .= "{{data." . $field->getName() . " | SiNo}}";
  }


  protected function time(Field $field){
    $this->string .= "{{data." . $field->getName() . "}}";
  }

  protected function timestamp(Field $field){
    $this->string .= "{{data." . $field->getName() . ".date | date:'dd/MM/yyyy'}} {{data." . $field->getName() . ".time}}";
  }



}
