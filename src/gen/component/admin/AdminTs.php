<?php

require_once("generate/GenerateFileEntity.php");

class Gen_AdminTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = PATH_GEN . "tmp/component/admin/" . $entity->getName("xx-yy") . "-admin/";
    $file = $entity->getName("xx-yy") . "-admin.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function hasRelationsFkTypeahead(){
    if(!$this->entity->hasRelationsFk()) return false;
    foreach($this->getEntity()->getFieldsFk() as $field) {    
      if($field->getSubtype() == "typeahead") return true;
    }
    return false;

  }

  protected function generateCode() {
    $this->start();
    $this->end();
  }

  protected function start() {
    $this->string .= "import { AdminComponent } from '@component/admin/admin.component';
import { OnInit, Component } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { Location } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { MessageService } from '@service/message/message.service';
import { ValidatorsService } from '@service/validators/validators.service';
import { SessionStorageService } from '@service/storage/session-storage.service';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-admin',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-admin.component.html',
})
export class " . $this->entity->getName("XxYy") . "AdminComponent extends AdminComponent implements OnInit {

  readonly entity: string = \"" . $this->entity->getName() . "\";

  sync: any = {
    " . $this->entity->getName() . ":null
  }

  constructor(
    protected fb: FormBuilder, 
    protected route: ActivatedRoute, 
    protected router: Router, 
    protected location: Location, 
    protected dd: DataDefinitionService, 
    protected message: MessageService, 
    protected validators: ValidatorsService,
    protected storage: SessionStorageService, 
  ) {
    super(fb, route, router, location, dd, message, validators, storage);
  }

";
  }



  protected function end() {
    $this->string .= "}

";
  }

}
