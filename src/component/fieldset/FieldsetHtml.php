<?php

require_once("GenerateFileEntity.php");

class FieldsetHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null) {
    $file = $entity->getName("xx-yy") . "-fieldset.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/fieldset/" . $entity->getName("xx-yy") . "-fieldset/";
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
";
  }


  protected function nf() {
    $fields = $this->getEntity()->getFieldsNf();

    foreach($fields as $field) {
      if(!$field->isAdmin()) continue;
      switch ( $field->getSubtype() ) {
        case "checkbox": $this->checkbox($field); break;
        case "date": $this->date($field);  break;
        //case "float": case "integer": case "cuil": case "dni": $this->number($field); break;
        case "year": $this->year($field); break;
        case "timestamp":
          //la administracion de timestamp se encuentra deshabilitada debido a que requiere de formato adicional
          //$this->timestamp($field);
        break;
        case "time": $this->time($field); break;
        case "select_text": $this->selectValues($field); break;
        case "select_int": $this->selectValues($field); break;
        case "textarea": $this->textarea($field); break;
        default: $this->defecto($field); //name, email
      }
    }
  }


  public function fk(){
    $fields = $this->getEntity()->getFieldsFk();

    foreach($fields as $field){
      if(!$field->isAdmin()) continue;
      switch($field->getSubtype()) {
        case "select": $this->select($field); break;
        case "typeahead": $this->typeahead($field); break;
        case "file": $this->file($field); break;
      }
    }
  }




  protected function date(Field $field) {
    $this->string .= "  <div class=\"form-group form-row\">
    <label class=\"col-sm-2 col-form-label\">{$field->getName('Xx yy')}</label>
    <div class=\"col-sm-10\">
      <div class=\"input-group\">
        <input class=\"form-control\" placeholder=\"dd/mm/yyyy\" ngbDatepicker #" . $field->getName("xxYy") . "_=\"ngbDatepicker\" formControlName=\"{$field->getName()}\" [ngClass]=\"{'is-invalid':({$field->getName("xxYy")}.invalid && ({$field->getName("xxYy")}.dirty || {$field->getName("xxYy")}.touched))}\">
        <div class=\"input-group-append\">
          <button class=\"btn btn-outline-secondary\" (click)=\"" . $field->getName("xxYy") . "_.toggle()\" type=\"button\">
            <span title=\"Calendario\" class=\"oi oi-calendar\"></span>
          </button>
          <button class=\"btn btn-outline-secondary\" (click)=\"" . $field->getName("xxYy") . ".setValue(null)\" type=\"button\">
            <span title=\"Limpiar\" class=\"oi oi-reload\"></span>
          </button>
        </div>
      </div>
";
      $this->templateErrorStart($field);
      $this->templateErrorIsNotNull($field); 
      $this->templateErrorIsUnique($field); 
      $this->templateErrorDate($field);
      $this->templateErrorEnd($field);

      $this->string .= "    </div>
  </div>
";
  }

  protected function time(Field $field) {
    $this->string .= "  <div class=\"form-group form-row\">
    <label class=\"col-sm-2 col-form-label\">{$field->getName('Xx yy')}</label>
    <div class=\"col-sm-10\">
      <ngb-timepicker  placeholder=\"hh:mm\" formControlName=\"" . $field->getName() . "\" [spinners]=\"false\" [ngClass]=\"{'is-invalid':(" . $field->getName("xxYy") . ".invalid && (" . $field->getName("xxYy") . ".dirty || " . $field->getName("xxYy") . ".touched))}\"></ngb-timepicker>
";
      $this->templateErrorStart($field);
      $this->templateErrorIsNotNull($field); 
      $this->templateErrorIsUnique($field); 
      //$this->templateErrorDate($field);
      $this->templateErrorEnd($field);

      $this->string .= "    </div>
  </div>
";
  }
  protected function timestamp(Field $field) {
    $this->string .= "  <div class=\"form-group form-row\">
    <label class=\"col-sm-2 col-form-label\">{$field->getName('Xx yy')}</label>
    <div class=\"col-sm-10\">
      <div class=\"input-group\" formGroupName=\"{$field->getName()}\">
        <input class=\"form-control\" placeholder=\"yyyy-mm-dd\" ngbDatepicker #" . $field->getName("xxYy") . "Date=\"ngbDatepicker\" formControlName=\"date\"  [ngClass]=\"{'is-invalid':" . $field->getName("xxYy") . ".date.invalid && " . $field->getName("xxYy") . ".date.dirty || " . $field->getName("xxYy") . ".date.touched))}\">
        <div class=\"input-group-append\">
          <button class=\"btn btn-outline-secondary\" (click)=\"" . $field->getName("xxYy") . "Date.toggle()\" type=\"button\">
            <span class=\"oi oi-calendar\"></span>
          </button>
        </div>
        <ngb-timepicker formControlName=\"time\"></ngb-timepicker>
      </div>
";
      //$this->templateError($field);
      $this->string .= "    </div>
  </div>
";
  }

  protected function year(Field $field) {

    $this->string .= "  <div class=\"form-group form-row\">
    <label class=\"col-sm-2 col-form-label\">" . $field->getName("Xx yy") . "</label>
    <div class=\"col-sm-10\">
      <input class=\"form-control\" placeholder=\"yyyy\" type=\"text\" formControlName=\"" . $field->getName() . "\"  [ngClass]=\"{'is-invalid':(" . $field->getName("xxYy") . ".invalid && (" . $field->getName("xxYy") . ".dirty || " . $field->getName("xxYy") . ".touched))}\">
";
      $this->templateErrorStart($field);
      $this->templateErrorIsNotNull($field); 
      $this->templateErrorYear($field); 
      $this->templateErrorIsUnique($field); 
      $this->templateErrorEnd($field);    
      $this->string .= "    </div>
  </div>
";
  }


  protected function defecto(Field $field) {

    $this->string .= "  <div class=\"form-group form-row\">
    <label class=\"col-sm-2 col-form-label\">" . $field->getName("Xx yy") . "</label>
    <div class=\"col-sm-10\">
      <input class=\"form-control\" type=\"text\" formControlName=\"" . $field->getName() . "\"  [ngClass]=\"{'is-invalid':(" . $field->getName("xxYy") . ".invalid && (" . $field->getName("xxYy") . ".dirty || " . $field->getName("xxYy") . ".touched))}\">
";
      $this->templateErrorStart($field);
      $this->templateErrorIsNotNull($field); 
      $this->templateErrorIsUnique($field); 
      $this->templateErrorEnd($field);    
      $this->string .= "    </div>
  </div>
";
  }


  protected function textarea(Field $field) {

    $this->string .= "  <div class=\"form-group form-row\">
    <label class=\"col-sm-2 col-form-label\">" . $field->getName("Xx yy") . "</label>
    <div class=\"col-sm-10\">
      <textarea class=\"form-control\" type=\"text\" formControlName=\"" . $field->getName() . "\"  [ngClass]=\"{'is-invalid':(" . $field->getName("xxYy") . ".invalid && (" . $field->getName("xxYy") . ".dirty || " . $field->getName("xxYy") . ".touched))}\"></textarea>
";
      $this->templateErrorStart($field);
      $this->templateErrorIsNotNull($field); 
      $this->templateErrorIsUnique($field); 
      $this->templateErrorEnd($field);    
      $this->string .= "    </div>
  </div>
";
  }


  protected function checkbox(Field $field) {
    $this->string .= "  <div class=\"form-group form-check\">
    <label class=\"form-check-label\">
      <input class=\"form-check-input\" type=\"checkbox\" formControlName=\"{$field->getName()}\"> {$field->getName()}
    </label>
";
    $this->templateErrorStart($field);
    $this->templateErrorEnd($field);
    $this->string .= "  </div>
";
  }

  protected function selectValues(Field $field){
    $this->string .= "  <div class=\"form-group form-row\">
    <label class=\"col-sm-2 col-form-label\">" . $field->getName("Xx Yy") . ":</label>
    <div class=\"col-sm-10\">
      <select class=\"form-control\" formControlName=\"" . $field->getName() . "\" [ngClass]=\"{'is-invalid':({$field->getName("xxYy")}.invalid && ({$field->getName("xxYy")}.dirty || {$field->getName("xxYy")}.touched))}\">
        <option [ngValue]=\"null\">--" . $field->getName("Xx Yy") . "--</option>
" ;

    foreach($field->getSelectValues() as $value) $this->string .= "            <option value=\"" . $value . "\">" . $value . "</option>
";

    $this->string .= "      </select>
";
    $this->templateErrorStart($field);
    $this->templateErrorIsNotNull($field); 
    $this->templateErrorIsUnique($field);
    $this->templateErrorEnd($field);
    $this->string .= "    </div>
  </div>
";

  }


  protected function select(Field $field) {
    $this->string .= "  <div class=\"form-group form-row\">
    <label class=\"col-sm-2 col-form-label\">" . $field->getName("Xx Yy") . "</label>
    <div class=\"col-sm-10\">
      <select class=\"form-control\" formControlName=\"" . $field->getName() . "\" [ngClass]=\"{'is-invalid':({$field->getName("xxYy")}.invalid && ({$field->getName("xxYy")}.dirty || {$field->getName("xxYy")}.touched))}\">
        <option [ngValue]=\"null\">--" . $field->getName("Xx Yy") . "--</option>
        <option *ngFor=\"let option of (opt" . $field->getEntityRef()->getName('XxYy') . "\$ | async)\" [value]=\"option.id\" >{{option.id | label:\"{$field->getEntityRef()->getName()}\"}}</option>
      </select>
";
    $this->templateErrorStart($field);
    $this->templateErrorIsNotNull($field); 
    $this->templateErrorIsUnique($field);
    $this->templateErrorEnd($field);
    $this->string .= "    </div>
  </div>
";
  }

  protected function typeahead(Field $field) {
    $this->string .= "  <div class=\"form-group row\">
    <label class=\"col-sm-2 col-form-label\">" . $field->getName("Xx Yy") . "</label>
    <div class=\"col-sm-10\">
      <app-typeahead [field]=\"" . $field->getName("xxYy") . "\" [entityName]=\"'" . $field->getEntityRef()->getName() . "'\"></app-typeahead>
";
      $this->templateErrorStart($field);
      $this->templateErrorIsNotNull($field); 
      $this->templateErrorIsUnique($field);
      $this->templateErrorEnd($field);
      
      $this->string .= "    </div>
  </div>
";
  }

  protected function file(Field $field) {
    $this->string .= "  <div class=\"form-group row\">
    <label class=\"col-sm-2 col-form-label\">" . $field->getName("Xx Yy") . "</label>
    <div class=\"col-sm-10\">
      <app-upload [field]=\"" . $field->getName("xxYy") . "\"></app-upload>
      <app-upload [field]=\"" . $field->getName("xxYy") . "\"></app-upload>
";
      $this->templateErrorStart($field);
      $this->templateErrorIsNotNull($field); 
      $this->templateErrorIsUnique($field);
      $this->templateErrorEnd($field);
      
      $this->string .= "    </div>
  </div>
";
  }



  protected function end() {
    if($this->entity->getFieldsUniqueMultiple()) $this->string .= "  <div class=\"text-danger\" *ngIf=\"fieldset.errors\">
    <div *ngIf=\"fieldset.errors.notUnique\">El valor ya se encuentra utilizado: <a routerLink=\"/{$this->entity->getName("xx-yy")}-admin\" [queryParams]=\"{'id':fieldset.errors.notUnique}\">Cargar</a></div>
  </div>
";
    $this->string .= "</fieldset>
";
  }

  protected function templateErrorStart(Field $field){
    $this->string .= "      <div class=\"text-danger\" *ngIf=\"({$field->getName("xxYy")}.touched || {$field->getName("xxYy")}.dirty) && {$field->getName("xxYy")}.invalid\">
";
  }

  protected function templateErrorEnd(Field $field){
    $this->string .= "      </div>
";
  }

  protected function templateErrorIsNotNull(Field $field){
    if($field->isNotNull()) $this->string .= "        <div *ngIf=\"{$field->getName("xxYy")}.errors.required\">Debe completar valor</div>
";
  }

  protected function templateErrorIsUnique(Field $field){
    if($field->isUnique()) $this->string .= "        <div *ngIf=\"{$field->getName("xxYy")}.errors.notUnique\">El valor ya se encuentra utilizado: <a routerLink=\"/{$field->getEntity()->getName("xx-yy")}-admin\" [queryParams]=\"{'{$field->getName()}':{$field->getName('xxYy')}.value}\">Cargar</a></div>
";
  }


  protected function templateErrorEmail(Field $field) {
    $this->string .= "        <div *ngIf=\"{$field->getName("xxYy")}.errors.email\">Debe ser un email válido</div>
";
  }


  protected function templateErrorYear(Field $field) {
    $this->string .= "        <div *ngIf=\"{$field->getName("xxYy")}.errors.nonNumeric\">Ingrese sólo números</div>
        <div *ngIf=\"{$field->getName("xxYy")}.errors.notYear\">No es un año válido</div>    
";
    if($field->getMinLength()) $this->string .= "        <div *ngIf=\"{$field->getName("xxYy")}.errors.minYear\">Valor no permitido</div>
";
    if($field->getLength()) $this->string .= "        <div *ngIf=\"{$field->getName("xxYy")}.errors.maxYear\">Valor no permitido</div>
";    
  }

  protected function templateErrorDate(Field $field) {
    $this->string .= "        <div *ngIf=\"{$field->getName("xxYy")}.errors.ngbDate\">Ingrese una fecha válida</div>
";
  }

  protected function templateErrorDni(Field $field) {
    $this->string .= "        <div *ngIf=\"{$field->getName("xxYy")}.errors.pattern\">Ingrese solo números</div>
        <div *ngIf=\"{$field->getName("xxYy")}.errors.minlength\">Longitud incorrecta</div>
        <div *ngIf=\"{$field->getName("xxYy")}.errors.maxlength\">Longitud incorrecta</div>
";
  }

}
