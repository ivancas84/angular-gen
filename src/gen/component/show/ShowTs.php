<?php

require_once("generate/GenerateFileEntity.php");

class Gen_ShowTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_ROOT_SITE."/" . "tmp/component/show/" . $entity->getName("xx-yy") . "-show/";
    $file = $entity->getName("xx-yy") . "-show.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { ShowComponent } from '@component/show/show.component';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-show',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-show.component.html',
})
export class " . $this->entity->getName("XxYy") . "ShowComponent extends ShowComponent {

  readonly entityName: string = \"" . $this->entity->getName() . "\";

  constructor(
    protected dd: DataDefinitionService, 
    protected route: ActivatedRoute, 
    protected router: Router
  ) {
    super(dd, route, router);
  }

}

";
  }

  protected function generateCode() { //@override
    $this->start();
  }

}
