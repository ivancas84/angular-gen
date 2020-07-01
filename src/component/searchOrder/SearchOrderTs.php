
<?php
require_once("GenerateFileEntity.php");

class Gen_SearchOrderTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search-order/" . $entity->getName("xx-yy") . "-search-order/";
    $file = $entity->getName("xx-yy") . "-search-order.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->start();
    $this->end();
  }

  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { SearchOrderComponent } from '@component/search-order/search-order.component';
    
@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-search-order',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-search-order.component.html',
})
export class " . $this->entity->getName("XxYy") . "SearchOrderComponent extends SearchOrderComponent {

  constructor( protected fb: FormBuilder )  { super(fb); }

";
  }

  protected function end(){
    $this->string .= "}
";
  }

}
