<?php

require_once("GenerateFileEntity.php");

class GenListTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/list/" . $entity->getName("xx-yy") . "-list/";
    $file = $entity->getName("xx-yy") . "-list.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "import { Component } from '@angular/core';
import { ShowElementComponent } from '@component/show-element/show-element.component';
import { Router } from '@angular/router';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-list',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-list.component.html',
})
export class " . $this->entity->getName("XxYy") . "ListComponent extends ShowElementComponent { 
  
  constructor(protected router: Router) { 
    super(router);
  }

}
";
  }

}

