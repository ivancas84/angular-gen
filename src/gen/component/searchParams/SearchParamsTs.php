
<?php
require_once("generate/GenerateFileEntity.php");

class Gen_SearchParamsTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = PATH_GEN . "tmp/component/search-params/" . $entity->getName("xx-yy") . "-search-params/";
    $file = $entity->getName("xx-yy") . "-search-params.component.ts";
    parent::__construct($dir, $file, $entity);
  }


  protected function generateCode(){
    $this->start();
    $this->initOptions();
    $this->initData();
    $this->formGroup();
    //$this->getters();
    $this->end();
  }


  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { isEmptyObject } from '@function/is-empty-object.function';
import { ValidatorsService } from '@service/validators/validators.service';
import { SearchParamsComponent } from '@component/search-params/search-params.component';
import { forkJoin } from 'rxjs';
import { Display } from '@class/display';
import { map } from 'rxjs/operators';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-search-params',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-search-params.component.html',
})
export class " . $this->entity->getName("XxYy") . "SearchParamsComponent extends SearchParamsComponent {
  readonly entityName = '" . $this->entity->getName() . "';

  constructor(
    protected fb: FormBuilder, 
    protected dd: DataDefinitionService, 
    protected validators: ValidatorsService) 
  { super(fb, dd, validators); }

";
  }

  protected function initData(){
    require_once("gen/component/searchParams/_InitData.php");
    $gen = new GenSearchParamsTs_initData($this->entity);
    $gen->dataName = "params";
    $this->string .= $gen->generate();
  }

  protected function initOptions(){
    require_once("gen/component/_initOptions/_InitOptions.php");
    $gen = new Gen_initOptions($this->entity);
    $this->string .= $gen->generate();
  }

  protected function formGroup(){
    require_once("gen/component/searchParams/_FormGroup.php");
    $gen = new Gen_SearchParamsTs_formGroup($this->entity);
    $this->string .= $gen->generate();
  }
  
  protected function getters(){
    foreach($this->entity->getFieldsByType(["nf","fk"]) as $field){
      if(!$field->isAdmin()) continue;
      $this->string .= "  get {$field->getName('xxYy')}() { return this.fieldset.get('{$field->getName()}')}
";
    }
    $this->string .= "
";
  }

  protected function end(){
    $this->string .= "}
";
  }





}
