<?php

require_once("GenerateFileEntity.php");

class Gen_SearchHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-search.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search/" . $entity->getName("xx-yy") . "-search/";
    parent::__construct($directorio, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "<div class=\"card\">
  <div class=\"card-header\" (click)=\"optCard = !optCard\">Opciones</div>
  <div class=\"card-body\" [hidden]=\"!optCard\">
    <form [formGroup]=\"searchForm\" novalidate (ngSubmit)=\"onSubmit()\">       
      <app-search-all [form]=\"searchForm\" [params$]=\"params$\"></app-search-all>
      <!--app-{$this->entity->getName('xx-yy')}-search-params [form]=\"searchForm\" [params$]=\"params$\"></app-{$this->entity->getName('xx-yy')}-search-params-->
      <!--app-{$this->entity->getName('xx-yy')}-search-condition [form]=\"searchForm\" [condition$]=\"condition$\"></app-{$this->entity->getName('xx-yy')}-search-condition-->
      <div class=\"ml-5\">
        <button type=\"submit\" class=\"btn btn-primary btn-sm\">Buscar <span class=\"oi oi-magnifying-glass\"></span></button>
      </div>
    </form>
  </div>
</div>
";
  }

}
