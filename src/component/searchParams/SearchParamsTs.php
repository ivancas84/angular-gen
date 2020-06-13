
<?php
require_once("GenerateFileEntity.php");

class Gen_SearchParamsTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search-params/" . $entity->getName("xx-yy") . "-search-params/";
    $file = $entity->getName("xx-yy") . "-search-params.component.ts";
    parent::__construct($dir, $file, $entity);
  }


  protected function generateCode(){
    $this->start();
    $this->declareOptions();
    $this->constructor();
    $this->initOptions();
    //$this->initData();
    /**
     * initData se utilizaba para inicializar principalmente los campos typeahead
     * Se hizo una nueva reimplementacion de typeahead para inicializar directamente en el mismo componente
     * se deja como referencia initData por si se necesita volver atras la nueva implementacion
     */
    $this->formGroup();
    //$this->getters();
    $this->end();
  }


  protected function start(){
    $this->string .= "import { Component } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { SearchParamsComponent } from '@component/search-params/search-params.component';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-search-params',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-search-params.component.html',
})
export class " . $this->entity->getName("XxYy") . "SearchParamsComponent extends SearchParamsComponent {

";
  }

  public function constructor(){
    $this->string .= "  constructor (
    protected fb: FormBuilder, 
    protected dd: DataDefinitionService
  ) { super(fb); }

";
  }

  protected function declareOptions(){
    require_once("component/_initOptions/_DeclareOptions.php");
    $gen = new Gen_declareOptions($this->entity);
    $this->string .= $gen->generate();
  }

  protected function initData(){
    require_once("component/searchParams/_InitData.php");
    $gen = new GenSearchParamsTs_initData($this->entity);
    $gen->dataName = "params";
    $this->string .= $gen->generate();
  }

  protected function initOptions(){
    require_once("component/_initOptions/_InitOptions.php");
    $gen = new Gen_initOptions($this->entity);
    $this->string .= $gen->generate();
  }

  protected function formGroup(){
    require_once("component/searchParams/_FormGroup.php");
    $gen = new Gen_SearchParamsTs_formGroup($this->entity);
    $this->string .= $gen->generate();
  }
  
  protected function getters(){
    foreach($this->entity->getFieldsByType(["nf","fk"]) as $field){
      if(!$field->isAdmin()) continue;
      $this->string .= "  get {$field->getName('xxYy')}() { return this.fieldset.get('{$field->getName()}')}
";
    }
    $this->string .= "
";
  }

  protected function end(){
    $this->string .= "}
";
  }





}
