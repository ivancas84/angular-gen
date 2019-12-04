<?php

require_once("generate/GenerateFileEntity.php");

class _ClassDataDefinition extends GenerateFileEntity {

  public function __construct(Entity $entity) {
    $dir = PATH_GEN."src/app/class/data-definition/" . $entity->getName("xx-yy") . "/";
    $file = "_" . $entity->getName("xx-yy") . "-data-definition.ts";
    parent::__construct($dir, $file, $entity);
  }

  protected function generateCode(){
    $this->imports();
    $this->start();
    $this->storage();
    //$this->options();
    $this->label();
    $this->end();

  }

  protected function start() {    
    $this->string .= "import { DataDefinition } from 'src/app/core/class/data-definition';

export class _" . $this->entity->getName("XxYy") . "DataDefinition extends DataDefinition {
  entity: string = '{$this->entity->getName()}';

";
  }

  protected function imports(){
    require_once("gen/class/data-definition/_Imports.php");
    $gen = new EntityDataDefinition_Imports($this->entity);
    $this->string .= $gen->generate();
  }

  protected function storage(){
    require_once("gen/class/data-definition/_Storage.php");
    $gen = new EntityDataDefinition_Storage($this->entity);
    $this->string .= $gen->generate();
  }

  protected function label(){
    require_once("gen/class/data-definition/_Label.php");
    $gen = new EntityDataDefinition_Label($this->entity);
    $this->string .= $gen->generate();
  }


  protected function options(){
    require_once("gen/class/data-definition/_Options.php");
    $gen = new EntityDataDefinition_Options($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end(){
    $this->string .= "}
";
  }



}
