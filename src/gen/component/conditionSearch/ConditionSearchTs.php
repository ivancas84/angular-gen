
<?php
require_once("generate/GenerateFileEntity.php");

class Gen_ConditionSearchTs extends GenerateFileEntity {


  public function __construct(Entity $entity) {
    $dir = PATH_GEN . "tmp/component/condition-search/" . $entity->getName("xx-yy") . "-condition-search/";
    $file = $entity->getName("xx-yy") . "-condition-search.component.ts";
    parent::__construct($dir, $file, $entity);
  }


  protected function generateCode(){
    $this->start();
    $this->initData();
    $this->end();
  }


  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { Router } from '@angular/router';
import { SearchComponent } from '@component/search/search.component';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { isEmptyObject } from '@function/is-empty-object.function';
import { forkJoin } from 'rxjs';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-condition-search',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-condition-search.component.html',
})
export class " . $this->entity->getName("XxYy") . "SearchComponent extends SearchComponent {
  entity = '" . $this->entity->getName() . "';

  constructor(protected fb: FormBuilder, protected dd: DataDefinitionService, protected router: Router)  {
    super(fb, dd, router);
  }

";
  }

  protected function initData(){
    require_once("gen/component/conditionSearch/_initData.php");
    $gen = new Gen_SearchTs_initData($this->entity);
    $this->string .= $gen->generate();
  }



  protected function end(){
    $this->string .= "}
";
  }





}
