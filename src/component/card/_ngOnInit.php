<?php

require_once("GenerateEntity.php");


class Gen_cardNgOnInit extends GenerateEntity {

  public function generate() {
    if(!count($this->entity->getFieldsFk())) return;
    $this->start();
    $this->body();
    $this->end();

    return $this->string;
  }
  
  protected function start() {
    $this->string .= "  ngOnInit(): void {

";

  }
  protected function body() {
    foreach($this->entity->getFieldsFk() as $field){
      $fieldName = $field->getName();
      $fieldName_ = $field->getName('xxYy');
      $entityName = $this->entity->getName('xxYy');
      $entityRefName = $field->getEntityRef()->getName();

      $this->string .= "    this.{$fieldName_}$ = this.data$.pipe(mergeMap(
      {$entityName} => {
        if(isEmptyObject({$entityName}) || !comision.hasOwnProperty('{$fieldName}') || !comision['$fieldName']) return of(null);
        return this.dd.get('{$entityRefName}', comision['{$fieldName}']);        
      }
    ));

";
    }
  }

  protected function end() {
    $this->string .= "  }

";
  }
}
