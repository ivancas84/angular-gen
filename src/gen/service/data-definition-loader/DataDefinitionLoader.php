<?php

require_once("generate/GenerateFile.php");

class DataDefinitionLoaderService extends GenerateFile {

  protected $structure; //estructura de tablas

  public function __construct(array $structure){
    $this->structure = $structure;
    parent::__construct(PATH_GEN."src/app/service/", "data-definition-loader.service.ts");

  }


  protected function generateCode(){
    $this->importsStart();
    $this->importsDataDefinition();
    $this->classStart();
    $this->methodGet();
    $this->classEnd();
  }


  protected function importsStart(){
    $this->string .= "import { Injectable } from '@angular/core';

import { DataDefinition } from '../core/service/data-definition/data-definition';
import { DataDefinitionService } from './data-definition/data-definition.service';

";
  }

  protected function importsDataDefinition(){
    foreach($this->structure as $entity){
      $this->string .= "import { " . $entity->getName("XxYy") . "DataDefinition } from './data-definition/" . $entity->getName("xx-yy") . "/" . $entity->getName("xx-yy") . "-data-definition';
";
    }
  }

  protected function classStart(){
    $this->string .= "

@Injectable({
  providedIn: 'root'
})
export class DataDefinitionLoaderService {
";
  }

  protected function methodGet(){
    require_once("gen/service/data-definition-loader/_get.php");
    $gen = new DataDefinitionLoaderService_get($this->structure);
    $this->string .= $gen->generate();
  }

  protected function classEnd(){
    $this->string .= "}
";
  }
}
