
<?php
require_once("generate/GenerateFileEntity.php");

class Gen_SearchConditionTs extends GenerateFileEntity {


  public function __construct(Entity $entity) {
    $dir = PATH_GEN . "tmp/component/search-condition/" . $entity->getName("xx-yy") . "-search-condition/";
    $file = $entity->getName("xx-yy") . "-search-condition.component.ts";
    parent::__construct($dir, $file, $entity);
  }


  protected function generateCode(){
    $this->start();
    $this->initOptions();
    $this->initFilters();
    $this->end();
  }


  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { SearchConditionComponent } from '@component/search-condition/search-condition.component';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { isEmptyObject } from '@function/is-empty-object.function';
import { Display } from '@class/display';
import { forkJoin } from 'rxjs';
import { map } from 'rxjs/operators';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-search-condition',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-search-condition.component.html',
})
export class " . $this->entity->getName("XxYy") . "SearchConditionComponent extends SearchConditionComponent {
  readonly entityName = '" . $this->entity->getName() . "';

  constructor(
    protected fb: FormBuilder, 
    protected dd: DataDefinitionService
  )  { super(fb, dd); }

";
  }

  protected function initFilters(){
    require_once("gen/component/searchCondition/_initFilters.php");
    $gen = new Gen_SearchConditionTs_initFilters($this->entity);
    $this->string .= $gen->generate();
  }

  protected function initOptions(){
    require_once("gen/component/_initOptions/_InitOptions.php");
    $gen = new Gen_initOptions($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end(){
    $this->string .= "}
";
  }





}
