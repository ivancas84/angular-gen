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
    $this->string .= "  initFilters(condition) {
    var obs = [];
 
    for(let i = 0; i < condition.length; i++){
      if((condition[i][0] == \"id\") && !isEmptyObject(condition[i][2])) {
        var ob = this.dd.getOrNull(this.entityName,condition[i][2]);
        obs.push(ob);
      }

";
}

protected function body() {
  foreach($this->fields as $field){
    $this->string .= "      if((condition[i][0] == \"" . $field->getEntityRef()->getName() . "\") && !isEmptyObject(condition[i][2])) {     
        var ob = this.dd.getOrNull(\"" . $field->getEntityRef()->getName() . "\",condition[i][2]);
        obs.push(ob);
      }

";
  }
}

  protected function end(){
    $this->string .= "    }
    return obs;
  }
";
  }



}
