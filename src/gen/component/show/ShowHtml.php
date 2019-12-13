<?php

require_once("generate/GenerateFileEntity.php");


class Gen_ShowHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-show.component.html";
    if(!$directorio) $directorio = PATH_GEN . "tmp/component/show/" . $entity->getName("xx-yy") . "-show/";
    parent::__construct($directorio, $file, $entity);
  }


  public function generateCode() {
    $this->string .= "<!-- app-" . $this->getEntity()->getName("xx-yy") . "-search [condition]=\"display.condition\" (conditionChange)=\"conditionChange(\$event)\"></app-" . $this->getEntity()->getName("xx-yy") . "-search -->
<app-" . $this->getEntity()->getName("xx-yy") . "-table [data$]=\"data$\" (orderChange)=\"orderChange(\$event)\"></app-" . $this->getEntity()->getName("xx-yy") . "-table>
<app-pagination [page]=\"display.page\" [size]=\"display.size\" [collectionSize$]=\"collectionSize$\" (pageChange)=\"pageChange(\$event)\"></app-pagination>
";

  }
}
