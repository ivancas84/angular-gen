
<?php
require_once("generate/GenerateFileEntity.php");

class Gen_SearchTs extends GenerateFileEntity {


  public function __construct(Entity $entity) {
    $dir = PATH_GEN . "tmp/component/search/" . $entity->getName("xx-yy") . "-search/";
    $file = $entity->getName("xx-yy") . "-search.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "import { Component } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { SearchComponent } from '@component/search/search.component';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-search',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-search.component.html',
})
export class " . $this->entity->getName("XxYy") . "SearchComponent extends SearchComponent {
  
  readonly entityName = '" . $this->entity->getName() . "';

  constructor(protected fb: FormBuilder) {
    super(fb);
  }

}
";
  }








}
