<?php

require_once("generate/GenerateEntity.php");


class GenCardTs_ngOnInit extends GenerateEntity {

  protected $fields = [];

  public function generate() {
    $this->setFields();
    if(!count($this->fields)) return;
    $this->start();
    $this->getOrNull();
    $this->end();

    return $this->string;
  }

  protected function setFields(){
    $this->fields = [];
    foreach($this->entity->getFieldsFk() as $field){
      if(!$field->isAdmin()) continue;
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


  protected function getOrNull() {
    foreach($this->fields as $field){
      $this->string .= "          if(response.{$field->getName()}) {
            var ob = this.dd.getAll(\"{$field->getName()}\",response.{$field->getName()});
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
