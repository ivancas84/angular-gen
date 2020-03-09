<?php

require_once("generate/GenerateFileEntity.php");

class GenCardTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = PATH_GEN . "tmp/component/card/" . $entity->getName("xx-yy") . "-card/";
    $file = $entity->getName("xx-yy") . "-card.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "import { Component } from '@angular/core';
import { CardComponent } from '@component/card/card.component';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-card',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-card.component.html',
})
export class " . $this->entity->getName("XxYy") . "CardComponent extends CardComponent { }
";
  }
}

