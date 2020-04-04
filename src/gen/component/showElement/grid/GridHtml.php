<?php

require_once("generate/GenerateFileEntity.php");


class GenGridHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-grid.component.html";
    if(!$directorio) $directorio = PATH_GEN . "tmp/component/grid/" . $entity->getName("xx-yy") . "-grid/";
    parent::__construct($directorio, $file, $entity);
  }

  protected function generateCode(){
    $this->start();
    $this->valuesFk();
    $this->newCol();
    $this->valuesNf();
    $this->end();
  }
  protected function start(){
    $this->string .= "
<ng-template #loading>No se han encontrado registros...</ng-template>

<div *ngIf=\"data$ | async as data; else loading\" class=\"container\">
  <div *ngIf=\"data.length\"> 
    <div *ngFor=\"let row of data; let i = index\" class=\"row align-items-center border\">
      <div class=\"col-md-4\">
        <h5 >{{row.id | label:'{$this->entity->getName()}'}}</h5>
";          
        
  }

  protected function end(){
    $this->string .= "      </div>
    </div>
  </div>
</div>
";
  }

  protected function valuesNf(){
    foreach ($this->getEntity()->getFieldsNf() as $field) {
      if($field->isHidden()) continue;
      /**
       * se omiten los campos ocultos
       */

      switch($field->getSubtype()){
        case "checkbox": $this->checkbox($field); break;
        case "date": $this->date($field); break;
        //case "timestamp": $this->timestamp($field); break;
        //case "time": $this->time($field); break;
        default: $this->defecto($field); break;
      }

      $this->string .= " " ;      
    }
    $this->string .= "
" ;      
  }



  protected function valuesFk(){
    $first = true;
    foreach($this->getEntity()->getFieldsFk() as $field){
      $this->string .= "          " ;
      if(!$first) $this->string .= "<br>" ;
      else $first = false;

      switch($field->getSubtype()){
        default: $this->string .= "<small><a [routerLink]=\"['/" . $field->getEntityRef()->getName("xx-yy") . "-show']\" [queryParams]=\"{id:row." . $field->getName() . "}\" >{{row." . $field->getName() . " | label:'{$field->getEntityRef()->getName()}'}}</a></small>" ;
      }
      $this->string .= "
" ;
    }
  }

  protected function newCol(){
    $this->string .= "      </div>
      <div class=\"col-md\">
";
  }



  protected function defecto(Field $field){
    $this->string .= "{{row." . $field->getName() . "}}";
  }



  protected function textarea(Field $field){
    $this->string .= "<span title=\"{{row." . $field->getName() . "}}\">{{row." . $field->getName() . " | summary}}</span>";
  }

  protected function date(Field $field){
    $this->string .= "{{row." . $field->getName() . " | toDate | date:'dd/MM/yyyy'}}";
  }

  protected function checkbox(Field $field){
    $this->string .= "{{row." . $field->getName() . " | siNo}}";
  }


  protected function time(Field $field){
    $this->string .= "{{row." . $field->getName() . "}}";
  }

  protected function timestamp(Field $field){
    $this->string .= "{{row." . $field->getName() . ".date | date:'dd/MM/yyyy'}} {{row." . $field->getName() . ".time}}";
  }

}
