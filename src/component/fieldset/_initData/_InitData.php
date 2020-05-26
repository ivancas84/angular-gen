<?php

require_once("GenerateEntity.php");


class Gen_initData extends GenerateEntity {

  protected $fields = [];
  public $dataName = "data$";

  public function generate() {
    $this->setFields();
    if(!count($this->fields)) return;
    $this->start();
    $this->body();
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
    $this->string .= "  initData(): void {
    this.data$.subscribe(
      response => {
        this.setDefaultValues();

        if(!isEmptyObject(response)) {
          var obs = [];

";
  }

  protected function body() {
    foreach($this->fields as $field){
      $this->string .= "          if(response." . $field->getName() . ")
            obs.push(
              this.dd.get(\"" . $field->getEntityRef()->getName() . "\",response." . $field->getName() . ")
            );

";
    }
  }

  protected function end() {
    $this->string .= "          if(obs.length){ forkJoin(obs).subscribe( () => this.fieldset.reset(response) ); } 
          else { this.fieldset.reset(response); }
        }
      }
    );
  }

";
  }
}
