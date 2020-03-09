<?php

require_once("generate/GenerateFileEntity.php");

class Gen_SearchParamsHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null) {
    $file = $entity->getName("xx-yy") . "-search-params.component.html";
    if(!$directorio) $directorio = PATH_GEN . "tmp/component/search-params/" . $entity->getName("xx-yy") . "-search-params/";
    parent::__construct($directorio, $file, $entity);
  }


  public function generateCode() {
    $this->start();
    $this->nf();
    $this->fk();
    $this->end();
  }

  protected function start() {
    $this->string .= "<fieldset [formGroup]=\"fieldset\">
  <div class=\"form-inline\">
";
  }


  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field) {
      switch ( $field->getSubtype() ) {
        case "checkbox": $this->checkbox($field); break;
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
    $this->string .= "    <div class=\"form-group mb-2\">
      <label class=\"col-form-label\">{$field->getName('Xx yy')}</label>
      <div class=\"input-group\" formGroupName=\"{$field->getName()}\">
        <input class=\"form-control\" placeholder=\"dd/mm/yyyy\" ngbDatepicker #" . $field->getName("xxYy") . "_=\"ngbDatepicker\" formControlName=\"{$field->getName()}\">
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
    $this->string .= "    <div class=\"form-group mb-2\">
      <label class=\"col-form-label\">" . $field->getName("Xx yy") . "</label>
      <input class=\"form-control\" placeholder=\"yyyy\" type=\"text\" formControlName=\"" . $field->getName() . "\">
    </div>
";
  }

  protected function defecto(Field $field) {

    $this->string .= "    <div class=\"form-group mb-2\">
      <label class=\"col-form-label\">" . $field->getName("Xx yy") . "</label>
      <input class=\"form-control\" type=\"text\" formControlName=\"" . $field->getName() . "\">
    </div>
";
  }

  protected function checkbox(Field $field) {
    $this->string .= "    <div class=\"form-group mb-2\">
      <label class=\"col-form-label\">" . $field->getName("Xx yy") . "</label>
      <select class=\"form-control\" formControlName=\"" . $field->getName() . "\">
        <option [ngValue]=\"null\">--Todos--</option>
        <option [ngValue]=\"'true'\">Sí</option>
        <option [ngValue]=\"'false'\">No</option>
      </select>
    </div>
";
  }

  protected function selectValues(Field $field){
    $this->string .= "    <div class=\"form-group mb-2\">
      <label class=\"col-form-label\">" . $field->getName("Xx Yy") . ":</label>
      <select class=\"form-control\" formControlName=\"" . $field->getName() . "\">
        <option [ngValue]=\"null\">--" . $field->getName("Xx Yy") . "--</option>
" ;

    foreach($field->getSelectValues() as $value) $this->string .= "            <option value=\"" . $value . "\">" . $value . "</option>
";

    $this->string .= "      </select>
    </div>
";

  }

  protected function select(Field $field) {
    $this->string .= "    <div class=\"form-group mb-2\">
      <label class=\"col-form-label\">" . $field->getName("Xx Yy") . ":</label>
      <select class=\"form-control\" formControlName=\"" . $field->getName() . "\">
        <option [ngValue]=\"null\">--" . $field->getName("Xx Yy") . "--</option>
        <option *ngFor=\"let option of (options | async)?." . $field->getEntityRef()->getName() . "\" [value]=\"option.id\" >{{option.id | label:\"{$field->getEntityRef()->getName()}\"}}</option>
      </select>
    </div>
";
  }

  protected function typeahead(Field $field) {
    $this->string .= "    <div class=\"form-group mb-2\">
      <label class=\"col-form-label\">" . $field->getName("Xx Yy") . "</label>
      <app-fieldset-typeahead [fieldset]=\"fieldset\" [entityName]=\"'" . $field->getEntityRef()->getName() . "'\" [fieldName]=\"'" . $field->getName() . "'\"></app-fieldset-typeahead>
    </div>
";
  }

  protected function end() {
    $this->string .= "  </div>
</fieldset>
";
  }




}
