<?php

require_once("GenerateFileEntity.php");

class Gen_SearchParamsHtml extends GenerateFileEntity {
  public $index = 0;

  public function __construct(Entity $entity, $directorio = null) {
    $file = $entity->getName("xx-yy") . "-search-params.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search-params/" . $entity->getName("xx-yy") . "-search-params/";
    parent::__construct($directorio, $file, $entity);
  }

  public function generateCode() {
    $this->start();
    $this->nf();
    $this->fk();
    $this->end();
  }

  protected function start() {
    $this->string .= "<fieldset *ngIf=\"load$ | async\" [formGroup]=\"fieldset\">
  <div class=\"form-inline\">
    <div class=\"form-row\">
";
  }

  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field) {
      switch ( $field->getSubtype() ) {
        case "checkbox": 
          $this->checkbox($field); 
        break;
        case "date": $this->date($field);  break;
        //case "float": case "integer": case "cuil": case "dni": $this->number($field); break;
        case "year": $this->year($field); break;
     
        case "select_text": $this->selectValues($field); break;
        case "select_int": $this->selectValues($field); break;
        case "textarea":         case "timestamp":
        break;
        default: $this->defecto($field); //name, email
      }
    }
  }

  public function newRow(){
    if ($this->index && ((($this->index) % 3) == 0)) $this->string .= "    </div>

    <div class=\"form-row\">
";
    $this->index++;
  }

  public function fk(){
    $fields = $this->getEntity()->getFieldsFk();

    foreach($fields as $field){
    
      switch($field->getSubtype()) {
        case "select": $this->select($field); break;
        case "typeahead": $this->typeahead($field); break;
      }
    }
  }


  protected function date(Field $field) {
    $this->newRow();
    $this->string .= "    <div class=\"form-group col-sm-4\">
      <div class=\"input-group\" formGroupName=\"{$field->getName()}\">
        <input class=\"form-control-sm\" placeholder=\"{$field->getName('Xx yy')}: dd/mm/yyyy\" ngbDatepicker #" . $field->getName("xxYy") . "_=\"ngbDatepicker\" formControlName=\"{$field->getName()}\">
        <div class=\"input-group-append\">
          <button class=\"btn btn-outline-secondary\" (click)=\"" . $field->getName("xxYy") . "_.toggle()\" type=\"button\">
            <span title=\"Calendario\" class=\"oi oi-calendar\"></span>
          </button>
          <button class=\"btn btn-outline-secondary\" (click)=\"" . $field->getName("xxYy") . ".setValue(null)\" type=\"button\">
            <span title=\"Limpiar\" class=\"oi oi-reload\"></span>
          </button>
        </div>
      </div>
    </div>
";
  }

  protected function year(Field $field) {
    $this->newRow();
    $this->string .= "    <div class=\"form-group col-sm-4\">
      <input class=\"form-control-sm\" placeholder=\"{$field->getName('Xx yy')}: yyyy\" type=\"text\" formControlName=\"" . $field->getName() . "\">
    </div>
";
  }

  protected function defecto(Field $field) {
    $this->newRow();
    $this->string .= "    <div class=\"form-group col-sm-4\">
      <input placeholder=\"{$field->getName('Xx yy')}\" class=\"form-control-sm\" type=\"text\" formControlName=\"" . $field->getName() . "\">
    </div>
";
  }

  protected function checkbox(Field $field) {
    $this->newRow();
    $this->string .= "    <div class=\"form-group col-sm-4\">
      <select class=\"form-control-sm\" formControlName=\"" . $field->getName() . "\">
        <option [ngValue]=\"null\">--{$field->getName('Xx yy')}--</option>
        <option [ngValue]=\"'true'\">Sí</option>
        <option [ngValue]=\"'false'\">No</option>
      </select>
    </div>
";
  }

  protected function selectValues(Field $field){
    $this->newRow();
    $this->string .= "    <div class=\"form-group col-sm-4\">
      <select class=\"form-control-sm\" formControlName=\"" . $field->getName() . "\">
        <option [ngValue]=\"null\">--" . $field->getName("Xx Yy") . "--</option>
" ;

    foreach($field->getSelectValues() as $value) $this->string .= "            <option value=\"" . $value . "\">" . $value . "</option>
";

    $this->string .= "      </select>
    </div>
";

  }

  protected function select(Field $field) {
    $this->newRow();
    $this->string .= "    <div class=\"form-group col-sm-4\">
      <select class=\"form-control-sm\" formControlName=\"" . $field->getName() . "\">
        <option [ngValue]=\"null\">--" . $field->getName("Xx Yy") . "--</option>
        <option *ngFor=\"let option of (opt" . $field->getEntityRef()->getName('XxYy') . "$ | async)\" [value]=\"option.id\" >{{option.id | label:\"{$field->getEntityRef()->getName()}\"}}</option>
      </select>
    </div>
";
  }

  protected function typeahead(Field $field) {
    $this->newRow();
    $this->string .= "    <div class=\"form-group col-sm-4\">
      <app-typeahead [field]=\"" . $field->getName("xxYy") . "\" [entityName]=\"'" . $field->getEntityRef()->getName() . "'\" [size]=\"sm\"></app-typeahead>
    </div>
";
  }

  protected function end() {
    $this->string .= "   </div>
  </div>
</fieldset>
";
  }
}