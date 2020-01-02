<?php

require_once("generate/GenerateFileEntity.php");

class Gen_SearchHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-search.component.html";
    if(!$directorio) $directorio = PATH_GEN . "tmp/component/search/" . $entity->getName("xx-yy") . "-search/";
    parent::__construct($directorio, $file, $entity);
  }

  protected function generateCode(){
    $this->string .= "<ngb-accordion #acc=\"ngbAccordion\">
  <ngb-panel>
    <ng-template ngbPanelTitle>
      <span>Opciones</span>
    </ng-template>
    <ng-template ngbPanelContent>
      <form [formGroup]=\"searchForm\" novalidate (ngSubmit)=\"onSubmit()\">       
        <app-search-all [form]=\"searchForm\" [data$]=\"params$\"></app-search-all>
        <!--app-sede-search-params [form]=\"searchForm\" [data$]=\"params$\"></app-sede-search-params-->
        <!--app-sede-search-condition [form]=\"searchForm\" [data$]=\"condition$\"></app-sede-search-condition-->
        <div class=\"ml-5\">
          <button type=\"submit\" class=\"btn btn-primary btn-sm\">Buscar <span class=\"oi oi-magnifying-glass\"></span></button>
        </div>
      </form>
    </ng-template>
  </ngb-panel>
</ngb-accordion>    
";
  }

}
