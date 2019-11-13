<?php

require_once("generate/GenerateEntity.php");


class FieldsetTs_initData extends GenerateEntity {

  protected $fields = [];

  public function generate() {
    $this->setFields();
    if(!count($this->fields)) return;
    $this->start();
    $this->isSync();
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
        if(!isEmptyObject(response)) {
          var obs = [];

";
  }

  protected function isSync() {
    foreach($this->fields as $field){
      $this->string .= "          if(this.dd.isSync('" . $field->getName() . "', this.sync) && response." . $field->getName() . ") {
            var ob = this.dd.getOrNull(\"" . $field->getEntityRef()->getName() . "\",response." . $field->getName() . ");
            obs.push(ob);
          }

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
