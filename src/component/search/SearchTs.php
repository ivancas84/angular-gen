
<?php
require_once("GenerateFileEntity.php");

class Gen_SearchTs extends GenerateFileEntity {


  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search/" . $entity->getName("xx-yy") . "-search/";
    $file = $entity->getName("xx-yy") . "-search.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "import { Component } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { Router } from '@angular/router';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { ToastService } from '@service/ng-bootstrap/toast.service';
import { SearchComponent } from '@component/search/search.component';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-search',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-search.component.html',
})
export class " . $this->entity->getName("XxYy") . "SearchComponent extends SearchComponent {

  constructor(
    protected fb: FormBuilder,
    protected router: Router,
    protected toast: ToastService, 
    protected modalService: NgbModal
  ) {
    super(fb, router, toast, modalService);
  }

}
";
  }








}
