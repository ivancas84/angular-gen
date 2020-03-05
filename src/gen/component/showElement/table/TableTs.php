<?php

require_once("generate/GenerateFileEntity.php");

class GenTableTs extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = PATH_GEN . "tmp/component/table/" . $entity->getName("xx-yy") . "-table/";
    $file = $entity->getName("xx-yy") . "-table.component.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->import();
    $this->start();
    //$this->ngOnOnit();
    $this->end();
  }

  protected function start(){
    $this->string .= "@Component({
  selector: 'app-" . $this->entity->getName("xx-yy") . "-table',
  templateUrl: './" . $this->entity->getName("xx-yy") . "-table.component.html',
})
export class " . $this->entity->getName("XxYy") . "TableComponent extends ShowElementComponent {

  readonly entityName = '" . $this->entity->getName() . "';

  constructor(protected dd: DataDefinitionService) {
    super();
  }

";
  }

  protected function import(){
    require_once("gen/component/showElement/_import.php");
    $gen = new GenShowElementTs_import($this->entity);
    $this->string .= $gen->generate();
  }


  protected function ngOnOnit(){
    require_once("gen/component/showElement/_ngOnInit.php");
    $gen = new GenShowElementTs_ngOnInit($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end(){
    $this->string .= "}
";
  }
}

