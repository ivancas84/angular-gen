<?php

require_once("GenerateFileEntity.php");

class GenTableTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/table/" . $entity->getName("xx-yy") . "-table/";
    $file = $entity->getName("xx-yy") . "-table.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "import { Component } from '@angular/core';
import { ShowElementComponent } from '@component/show-element/show-element.component';
import { Router } from '@angular/router';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-table',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-table.component.html',
})
export class " . $this->entity->getName("XxYy") . "TableComponent extends ShowElementComponent { 
  
  constructor(protected router: Router) { 
    super(router);
  }

}
";
  }

}

