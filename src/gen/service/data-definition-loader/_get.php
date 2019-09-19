<?php

require_once("generate/Generate.php");

class DataDefinitionLoaderService_get extends Generate {

  protected $structure; //estructura de tablas

  public function __construct(array $structure){
    $this->structure = $structure;
  }


  protected function start(){
    $this->string .= "  get(name: string): DataDefinition {
    switch(name) {
";
  }

  protected function body(){
    foreach($this->structure as $entity){
      $this->string .= "        case \"" . $entity->getName() . "\": { return new " . $entity->getName("XxYy") . "DataDefinition(dd); }
";
      }
  }

  protected function end(){
    $this->string .= "     }
  }
";
  }

  public function generate(){
    $this->start();
    $this->body();
    $this->end();
    return $this->string;
  }


}
