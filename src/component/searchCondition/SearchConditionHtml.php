<?php

require_once("GenerateFileEntity.php");

class Gen_SearchConditionHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-search-condition.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search-condition/" . $entity->getName("xx-yy") . "-search-condition/";
    parent::__construct($directorio, $file, $entity);
  }


  public function generateCode() {
    $this->start();

    $this->selectPk();
    $this->selectNfFk();
    $this->selectEnd();

    $this->optionsStart();
    $this->optionsNf();
    $this->optionsFk();
    $this->optionsEnd();

    $this->switchStart();
    $this->switchPk();
    $this->switchNf();
    $this->switchFk();
    $this->switchEnd();

    $this->end();
  }


  protected function start(){
    $this->string .= "<fieldset *ngIf=\"params$ | async as condition\" [formGroup]=\"form\">

  <div formArrayName=\"filters\">
    <div class=\"form-row align-items-center\" *ngFor=\"let filter of filters.controls; let i=index\" [formGroupName]=\"i\">
      <div class=\"col-xs-4\">
        <select class=\"form-control form-control-sm\" formControlName=\"field\">
          <option value=\"\">--Campo--</option>
          <option value=\"_search\">Todos</option>
";
  }

  protected function selectPk(){
   $field = $this->entity->getPk();
   $this->string .= "          <option value=\"" . $field->getName() . "\">" . $field->getEntity()->getName("Xx Yy") . "</option>
";
  }

  protected function selectNfFk(){
   $fields = $this->entity->getFieldsByType(["nf","fk"]);
   foreach($fields as $field) {
     if($field->isHidden()) continue;
      $this->string .= "          <option value=\"" . $field->getName() . "\">" . $field->getName("Xx Yy") . "</option>
";
    }
  }

  protected function selectEnd(){
    $this->string .= "        </select>
      </div>

";
  }




  protected function optionsStart(){
    $this->string .= "      <div class=\"col-xs-2\" [ngSwitch]=\"f(i)\" >   
        <!-- todos -->
        <select *ngSwitchCase=\"'_search'\" class=\"form-control form-control-sm\" formControlName=\"option\">
          <option value=\"=~\">&cong;</option>
        </select>

        <!-- id -->
        <select *ngSwitchCase=\"'id'\" class=\"form-control form-control-sm\" formControlName=\"option\">
          <option value=\"=\">=</option>
          <option value=\"!=\">&ne;</option>
        </select>

";
   }

  protected function optionsNf(){
    $fields = $this->entity->getFieldsByType(["nf"]);
    foreach($fields as $field) {
      if($field->isHidden()) continue;

    $this->string .= "        <!-- " . $field->getName() . " -->
        <select *ngSwitchCase=\"'" . $field->getName() . "'\" class=\"form-control form-control-sm\" formControlName=\"option\">
          <option value=\"=~\">&cong;</option>
          <option value=\"!=~\">&#8775;</option>
          <option value=\"=\">=</option>
          <option value=\"!=\">&ne;</option>
          <option value=\"<=\">&le;</option>
          <option value=\">=\">&ge;</option>
        </select>
    
";
    }
  }
 
  protected function optionsFk(){
    $fields = $this->entity->getFieldsByType(["fk"]);
    foreach($fields as $field) {
      if($field->isHidden()) continue;

    $this->string .= "      <!-- " . $field->getName() . " -->
        <select *ngSwitchCase=\"'" . $field->getName() . "'\" class=\"form-control form-control-sm\" formControlName=\"option\">
          <option value=\"=\">=</option>
          <option value=\"!=\">&ne;</option>
        </select>

";
    }
  }

  protected function optionsEnd(){
    $this->string .= "      </div>

";
  }



  protected function switchStart(){
    $this->string .= "      <div class=\"col-xs-4\" [ngSwitch]=\"f(i)\" >
        <!-- todos -->
        <input *ngSwitchCase=\"'_search'\" class=\"form-control form-control-sm\" formControlName=\"value\">

";
  }

  protected function switchPk(){
    $field = $this->entity->getPk();
    $this->typeahead($field->getName(), $field->getEntity()->getName());
  }


  protected function switchNf(){
    $fieldsNf = $this->entity->getFieldsNf();

    foreach($fieldsNf as $field) {
      if($field->isHidden()) continue;

      switch($field->getSubtype()) {
        //case "date": $this->date($field); break;
        case "checkbox": $this->checkbox($field); break;

        default: $this->defecto($field->getName()); break;
      }
    }
  }


  protected function switchFk(){
    $fieldsNf = $this->entity->getFieldsFk();

    foreach($fieldsNf as $field) {
      if($field->isHidden()) continue;

      switch($field->getSubtype()) {
        //case "date": $this->date($field); break;
        default: $this->typeahead($field->getName(), $field->getEntityRef()->getName()); break;
      }
    }
  }

  protected function switchEnd(){
   $this->string .= "        <div *ngSwitchDefault>Seleccione campo</div>
      </div>
";
  }






  protected function defecto($fieldName){
    $this->string .= "        <!-- " . $fieldName . " -->
        <input *ngSwitchCase=\"'" . $fieldName . "'\" class=\"form-control form-control-sm\" formControlName=\"value\">

";
  }

  protected function checkbox(Field $field){
    
  }

  protected function typeahead($fieldName, $entityName){
    $this->string .= "        <!-- " . $fieldName . " -->
        <app-typeahead *ngSwitchCase=\"'" . $fieldName . "'\" [entityName]=\"'" . $entityName . "'\" [field]=\"v(i)\" ></app-typeahead>

";

  }

  protected function select(Field $field, Entity $entity, $prefix = ""){
    $this->string .= "        <div class=\"form-row\" *ngSwitchCase=\"'{$prefix}{$field->getName()}'\">
          <div class=\"col-sm-3\">
            <select class=\"form-control form-control-sm\" formControlName=\"option\">
              <option value=\"=\">=</option>
              <option value=\"!=\">&ne;</option>
            </select>
          </div>
          <div class=\"col\">
            <select class=\"form-control form-control-sm\" formControlName=\"value\" >
              <option *ngFor=\"let opt of options." . $field->getEntityRef()->getName() . "\" [value]=\"opt.id\" >{{opt.id | label:\"{$field->getEntityRef()->getName()}\"}}</option>
            </select>
          </div>
        </div>
";

  }


  protected function end(){
    $this->string .= "      <div class=\"col-xs-2\">
        <button type=\"button\" class=\"btn btn-danger btn-sm\" (click)=\"removeFilter(i)\"><span class=\"oi oi-x\"></span></button>
        <button *ngIf=\"(filters.controls.length == (i+1))\" type=\"button\" class=\"btn btn-info btn-sm\" (click)=\"addFilter()\"><span class=\"oi oi-layers\"></span></button>
      </div>
    </div>
  </div> <!-- formArrayName=\"filters\" -->

  <div *ngIf=\"(filters.controls.length == 0)\" class=\"form-row\">
    <div class=\"col\">
      <button type=\"submit\" class=\"btn btn-primary btn-sm\"><span class=\"oi oi-magnifying-glass\"></span></button>
    </div>
  </div>
</fieldset>
";
  }






















}
