<?php

require_once("generate/GenerateFileEntity.php");

class Gen_DetailTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/detail/" . $entity->getName("xx-yy") . "-detail/";
    $file = $entity->getName("xx-yy") . "-detail.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function start(){
    $this->string .= "import { OnInit, Component } from '@angular/core';
import { Location } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { ToastService } from '@service/ng-bootstrap/toast.service';
import { DetailComponent } from '@component/detail/detail.component';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-detail',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-detail.component.html',
})
export class " . $this->entity->getName("XxYy") . "DetailComponent extends DetailComponent {

  entityName: string = \"" . $this->entity->getName() . "\";

  constructor(
    protected route: ActivatedRoute,
    protected router: Router,
    protected location: Location,
    protected dd: DataDefinitionService,
    protected toast: ToastService,
  ) {
    super(route, router, location, dd, toast);
  }

}
";
  }

  protected function generateCode() {
    $this->start();
  }

}
