<?php

require_once("GenerateFileEntity.php");


class TypescriptEntityMain extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-main.ts";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "src/app/class/entity/{$entity->getName("xx-yy")}/";
    parent::__construct($directorio, $file, $entity);
  }


  public function generateCode() {
    $this->start();
    $this->properties();
    $this->constructor();
    //$this->initJson();
    $this->end();
  }


  protected function start(){
    $this->string .= "import { Entity } from '../../../core/class/entity';

export class " . $this->entity->getName("XxYy") . "Main extends Entity {
";
  }

  protected function properties(){
    require_once("angulariogen/class/entity/_Properties.php");
    $gen = new TypescriptEntity_properties($this->entity);
    $this->string .= $gen->generate();
  }

  protected function constructor(){
    require_once("angulariogen/class/entity/_Constructor.php");
    $gen = new TypescriptEntity_constructor($this->entity);
    $this->string .= $gen->generate();
  }


  protected function initJson(){
    require_once("angulariogen/class/entity/_InitJson.php");
    $gen = new TypescriptEntity_initJson($this->entity);
    $this->string .= $gen->generate();
  }

  protected function end(){
    $this->string .= "}

";
  }









}
