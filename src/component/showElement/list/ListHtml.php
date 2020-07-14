<?php

require_once("GenerateFileEntity.php");


class GenListHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-list.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/list/" . $entity->getName("xx-yy") . "-list/";
    parent::__construct($directorio, $file, $entity);
  }

  protected function generateCode(){
    $this->start();
    $this->valuesNf();
    $this->valuesFk();
    $this->end();
  }
  protected function start(){
    $this->string .= "<ng-template #empty>
  <div>No se han encontrado registros.</div>
</ng-template>
  
<div *ngIf=\"data$ | async as data; else empty\">

  <ul *ngIf=\"data && data.length; else empty\" class=\"list-group\">
    <li *ngFor=\"let row of data; let i = index\" class=\"list-group-item list-group-item-action d-flex justify-content-between align-items-center\">
      <div>
        <strong>{{row.id | label:'{$this->entity->getName()}'}}</strong>
        ";          
        
  }

  protected function end(){
    $this->string .= "      </div>
      <!--button type=\"button\" class=\"btn btn-sm btn-danger\"><span class=\"oi oi-delete\"></span></button-->
    </li>
  </ul>

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
      $this->string .= "        " ;
      if(!$first) $this->string .= "<br>" ;
      else $first = false;

      switch($field->getSubtype()){
        default: $this->string .= "<small><a [routerLink]=\"['/" . $field->getEntityRef()->getName("xx-yy") . "-show']\" [queryParams]=\"{id:row." . $field->getName() . "}\" >{{row." . $field->getName() . " | label:'{$field->getEntityRef()->getName()}'}}</a></small>" ;
      }
      $this->string .= "
" ;
    }
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
    $this->string .= "{{row." . $field->getName() . " | toDate | date:'HH:mm'}}";
  }

  protected function timestamp(Field $field){
    $this->string .= "{{row." . $field->getName() . ".date | toDate | date:'dd/MM/yyyy'}} {{row." . $field->getName() . ".time | toDate | date:'HH:mm'}}";
  }

}
