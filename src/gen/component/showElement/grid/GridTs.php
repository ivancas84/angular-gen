<?php

require_once("generate/GenerateFileEntity.php");

class GenGridTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_ROOT_SITE."/" . "tmp/component/grid/" . $entity->getName("xx-yy") . "-grid/";
    $file = $entity->getName("xx-yy") . "-grid.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "import { Component } from '@angular/core';
import { ShowElementComponent } from '@component/show-element/show-element.component';
    
@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-grid',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-grid.component.html',
})
export class " . $this->entity->getName("XxYy") . "GridComponent extends ShowElementComponent { }

";
  }
}

