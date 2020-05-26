<?php

require_once("GenerateEntity.php");


class GenSearchParamsTs_initData extends GenerateEntity {
/**
 * Este metodo es similiar al initData utilizado en los formularios de administracion
 * la diferencia es que en los formularios de administracion se inicializan los valores por defecto
 * para los formularios de busqueda los valores por defecto son definidos directamente en el componente padre que es el que realiza la busqueda.
 */
  protected $fields = [];

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
    this.params$.subscribe(
      response => {
        if(!isEmptyObject(response)) {
          var obs = [];

";
  }

  protected function body() {
    foreach($this->fields as $field){
      $this->string .= "          if(response." . $field->getName() . ") {
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
