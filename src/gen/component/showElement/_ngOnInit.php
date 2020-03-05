<?php

require_once("generate/GenerateEntity.php");


class GenShowElementTs_ngOnInit extends GenerateEntity {

  protected $fields = [];

  public function generate() {
    $this->setFields();
    if(!count($this->fields)) return;
    $this->start();
    $this->declareIds();
    $this->startLoop();
    $this->loop();
    $this->endLoop();
    $this->getAll();
    $this->end();

    return $this->string;
  }

  protected function setFields(){
    $this->fields = [];
    foreach($this->entity->getFieldsFk() as $field){
      if($field->isHidden()) continue;
      if($field->getSubtype() == "typeahead") array_push($this->fields, $field);      
    }
  }

  protected function start() {
    $this->string .= "  ngOnInit(): void {
    this.data$.subscribe(
      response => {
        if(!isEmptyObject(response)) {
          var obs = [];
";
  }

  protected function declareIds(){
    foreach($this->fields as $field){
      $this->string .= "          var ids{$field->getName('XxYy')} = [];    
";  
    }
  }

  protected function startLoop() {
    $this->string .= "
          for(var i in response){
";
  }

  protected function loop() {
    foreach($this->fields as $field){
      $this->string .= "            if(response[i].{$field->getName()}) ids{$field->getName('XxYy')}.push(response[i].{$field->getName()});
";
    }
  }

  protected function endLoop() {
    $this->string .= "          }

";
  }

  protected function getAll() {
    foreach($this->fields as $field){
      $this->string .= "          if(ids{$field->getName('XxYy')}.length) {
            var ob = this.dd.getAll(\"{$field->getEntityRef()->getName()}\",ids{$field->getName('XxYy')});
            obs.push(ob);
          }

";
    }
  }




  protected function end() {
    $this->string .= "          if(obs.length){ forkJoin(obs).subscribe( () => this.load$.next(true)) } 
          else { this.load$.next(true) }
        }
      }
    );
  }

";
  }
}
