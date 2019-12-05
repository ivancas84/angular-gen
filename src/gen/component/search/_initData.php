<?php

require_once("generate/GenerateEntity.php");

class Gen_SearchTs_initData extends GenerateEntity {

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


  protected function start(){
    $this->string .= "  initData() {
    var obs = [];
 
    for(let i = 0; i < this.condition.length; i++){
      if((this.condition[i][0] == \"id\") && !isEmptyObject(this.condition[i][2])) {
        var ob = this.dd.getOrNull(this.entityName,this.condition[i][2]);
        obs.push(ob);
      }

";
}

protected function body() {
  foreach($this->fields as $field){
    $this->string .= "      if((this.condition[i][0] == \"" . $field->getEntityRef()->getName() . "\") && !isEmptyObject(this.condition[i][2])) {     
        var ob = this.dd.getOrNull(\"" . $field->getEntityRef()->getName() . "\",this.condition[i][2]);
        obs.push(ob);
      }

";
  }
}

  protected function end(){
    $this->string .= "    }
    if(obs.length){ forkJoin(obs).subscribe( () => this.initForm() ); }
    else { this.initForm() }
  }
";
  }



}
