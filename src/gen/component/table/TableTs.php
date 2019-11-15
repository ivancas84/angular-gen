<?php

require_once("generate/GenerateFileEntity.php");

class TableTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = PATH_GEN . "tmp/component/table/" . $entity->getName("xx-yy") . "-table/";
    $file = $entity->getName("xx-yy") . "-table.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "import { Component } from '@angular/core';
import { TableComponent } from '@component/table/table.component';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-table',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-table.component.html',
})
export class " . $this->entity->getName("XxYy") . "TableComponent extends TableComponent {

  constructor(protected dd: DataDefinitionService) {
    super(dd);
    this.entity = '" . $this->entity->getName() . "';
  }

}

";
  }
}
