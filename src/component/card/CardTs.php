<?php

require_once("generate/GenerateFileEntity.php");

class GenCardTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/card/" . $entity->getName("xx-yy") . "-card/";
    $file = $entity->getName("xx-yy") . "-card.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  public function generateCode() {
    $this->imports();
    $this->declaration();
    $this->attributes();
    $this->constructor();
    $this->ngOnInit();
    $this->end();

  }

  protected function imports(){
    $this->string .= "import { Component } from '@angular/core';
import { CardComponent } from '@component/card/card.component';
";      
  
    if(count($this->entity->getFieldsFk())){
      $this->string .= "import { Observable, of } from 'rxjs';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { mergeMap } from 'rxjs/operators';
import { isEmptyObject } from '@function/is-empty-object.function';
";      
    }

    $this->string .= "
";    
  }

  protected function declaration(){
    $this->string .= "@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-card',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-card.component.html',
})
export class " . $this->entity->getName("XxYy") . "CardComponent extends CardComponent {

";
  }

  protected function attributes(){
    foreach($this->entity->getFieldsFk() as $field){
      $fieldName_ = $field->getName('xxYy');
      $this->string .= "  {$fieldName_}\$: Observable<any>;
";
    }
    $this->string .= "
";    
  }

  protected function constructor() {
    if(!count($this->entity->getFieldsFk())) return;
    $this->string .= "  constructor(
    protected dd: DataDefinitionService,
  ) {
    super();
  }

";
  }

  protected function ngOnInit() {
    require_once("component/card/_ngOnInit.php");
    $gen = new Gen_cardNgOnInit($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end() {
    $this->string .= "}
";
  }
}



