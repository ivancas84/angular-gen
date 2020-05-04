<?php

require_once("generate/GenerateFileEntity.php");


class Gen_DetailHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-detail.component.html";
    if(!$directorio) $directorio = PATH_GEN . "tmp/component/detail/" . $entity->getName("xx-yy") . "-detail/";
    parent::__construct($directorio, $file, $entity);
  }


  public function generateCode() {
    $this->string .= "<app-comision-card [data$]=\"data$\"></app-comision-card>
";

  }
}
