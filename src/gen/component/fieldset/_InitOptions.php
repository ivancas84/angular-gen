<?php

require_once("generate/GenerateEntity.php");


class FieldsetTs_initOptions extends GenerateEntity {

  protected $fields = [];

  public function generate() {
    $this->setFields();
    if(!count($this->fields)) return;
    $this->start();
    $this->isSync();
    $this->forkJoinStart();
    $this->forkJoinBody();
    $this->forkJoinEnd();
    $this->end();

    return $this->string;
  }

  protected function setFields(){
    $this->fields = [];
    foreach($this->entity->getFieldsFk() as $field){
      if(!$field->isAdmin()) continue;
      if($field->getSubtype() == "select") array_push($this->fields, $field);      
    }
  }

  protected function start() {
    $this->string .= "  initOptions(): void {
    let obs = [];      
";
  }

  protected function isSync() {
    foreach($this->fields as $field){
      $this->string .= "
    var ob = this.dd.all('tipo_sede', new Display);
    obs.push(ob);
";
    }
  }

  protected function forkJoinStart() {
    $this->string .= "
    this.options = forkJoin(obs).pipe(
      map(
        options => {
          var o = {};
";
  }

  protected function forkJoinBody(){
    for($i = 0; $i < count($this->fields); $i++) {
      $this->string .= "          o['" . $this->fields[$i]->getName() . "'] = options[{$i}];
";
    }
  }

  protected function forkJoinEnd(){
    $this->string .= "          return o;
        }
      )
    );
";
  }

  protected function end() {
    $this->string .= "  }

";
  }
}
