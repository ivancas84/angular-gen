<?php

require_once("GenerateFileEntity.php");

class GenGridTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/grid/" . $entity->getName("xx-yy") . "-grid/";
    $file = $entity->getName("xx-yy") . "-grid.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "import { Component } from '@angular/core';
import { ShowElementComponent } from '@component/show-element/show-element.component';
import { Router } from '@angular/router';
    
@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-grid',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-grid.component.html',
})
export class " . $this->entity->getName("XxYy") . "GridComponent extends ShowElementComponent { 
 
  constructor(protected router: Router) { 
    super(router);
  }

}
";
  }
}

