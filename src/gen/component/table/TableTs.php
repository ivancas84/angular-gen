<?php

require_once("generate/GenerateFileEntity.php");

class TableTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = PATH_GEN . "tmp/component/table/" . $entity->getName("xx-yy") . "-table/";
    $file = $entity->getName("xx-yy") . "-table.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->start();
    //$this->ngOnOnit();
    $this->end();
  }

  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { TableComponent } from '@component/table/table.component';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { isEmptyObject } from '@function/is-empty-object.function';
import { forkJoin } from 'rxjs';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-table',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-table.component.html',
})
export class " . $this->entity->getName("XxYy") . "TableComponent extends TableComponent {

  readonly entityName = '" . $this->entity->getName() . "';

  constructor(protected dd: DataDefinitionService) {
    super();
  }

";
  }

  protected function ngOnOnit(){
    require_once("gen/component/table/_ngOnInit.php");
    $gen = new GenTableTs_ngOnInit($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end(){
    $this->string .= "}
";
  }
}

