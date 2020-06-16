<?php

require_once("GenerateFileEntity.php");

class GenFormPickTs extends GenerateFileEntity {

  protected $options = []; //opciones

  public function __construct(Entity $entity) {
    $file = $entity->getName("xx-yy") . "-form-pick.component.ts";
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/form-pick/" . $entity->getName("xx-yy") . "-form-pick/";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    if(!$this->entity->getFieldsUniqueMultiple()) return "";
    $this->start();
    $this->declareOptions();
    $this->constructor();
    $this->initOptions();
    $this->formGroup();
    $this->getters();
    $this->end();
  }

  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { FormPick } from '@component/form-pick/form-pick.component';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { ValidatorsService } from '@service/validators/validators.service';
import { forkJoin, Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { Display } from '@class/display';
import { isEmptyObject } from '@function/is-empty-object.function';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-form-pick',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-form-pick.component.html',
})
export class " . $this->entity->getName("XxYy") . "FormPick extends FormPickComponent {

  readonly entityName: string = '" . $this->entity->getName() . "';

";
  }

  protected function constructor(){
    $this->string .= "  constructor(
    protected fb: FormBuilder, 
    protected dd: DataDefinitionService
  ) {
    super(fb, dd);
  }

";
  }

  protected function declareOptions(){
    require_once("component/_initOptions/_DeclareOptions.php");
    $gen = new Gen_declareOptions($this->entity);
    $this->string .= $gen->generate("unique_multiple");
  }

  protected function initOptions(){
    require_once("component/_initOptions/_InitOptions.php");
    $gen = new Gen_initOptions($this->entity);
    $this->string .= $gen->generate("unique_multiple");
  }

  protected function getters(){
    foreach($this->entity->getFieldsUniqueMultiple() as $field){
      $this->string .= "  get {$field->getName('xxYy')}() { return this.fieldset.get('{$field->getName()}')}
";
    }
    $this->string .= "
";
  }

  protected function formGroup(){
    require_once("component/formPick/_FormGroup.php");
    $gen = new GenFormPick_formGroup($this->entity);
    $this->string .= $gen->generate();
  }



  protected function end(){
    $this->string .= "}
";
  }

}