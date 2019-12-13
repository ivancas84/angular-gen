<?php

require_once("generate/GenerateFileEntity.php");

class GenCardTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = PATH_GEN . "tmp/component/card/" . $entity->getName("xx-yy") . "-card/";
    $file = $entity->getName("xx-yy") . "-card.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->start();
    $this->ngOnOnit();
    $this->end();
  }

  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { CardComponent } from '@component/card/card.component';
import { isEmptyObject } from '@function/is-empty-object.function';
import { forkJoin } from 'rxjs';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-card',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-card.component.html',
})
export class " . $this->entity->getName("XxYy") . "CardComponent extends CardComponent {

  readonly entityName = '" . $this->entity->getName() . "';

  constructor(protected dd: DataDefinitionService) {
    super(dd);
  }

";
  }

  protected function ngOnOnit(){
    require_once("gen/component/card/_ngOnInit.php");
    $gen = new GenCardTs_ngOnInit($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end(){
    $this->string .= "}
";
  }
}

