<?php

require_once("GenerateFileEntity.php");

class Gen_SearchOrderHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-search-order.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/search-order/" . $entity->getName("xx-yy") . "-search-order/";
    parent::__construct($directorio, $file, $entity);
  }


  public function generateCode() {
    $this->start();

    $this->selectNf();
    $this->selectEnd();

    $this->end();
  }


  protected function start(){
    $this->string .= "<fieldset *ngIf=\"load\$ | async\" [formGroup]=\"form\">
  <div formArrayName=\"order\">
    <div class=\"form-row align-items-center\" *ngFor=\"let element of elements.controls; let i=index\" [formGroupName]=\"i\">
      <div class=\"col-xs-4\">
      <select class=\"form-control form-control-sm\" formControlName=\"key\" [ngClass]=\"{'is-invalid':(k(i).invalid && (k(i).dirty || k(i).touched))}\">
          <option value=\"\">--Campo--</option>
";
  }


  protected function selectNf(){
   $fields = $this->entity->getFieldsNf();
   foreach($fields as $field) {
     if($field->isHidden()) continue;
      $this->string .= "          <option value=\"" . $field->getName() . "\">" . $field->getName("Xx Yy") . "</option>
";
    }
  }

  protected function selectEnd(){
    $this->string .= "        </select>
      </div>

";
  }

  protected function end(){
    $this->string .= "      <div class=\"col-xs-2\">   
        <select class=\"form-control form-control-sm\" formControlName=\"value\">
          <option value=\"asc\">ASC</option>
          <option value=\"desc\">DESC</option>
        </select>  
      </div>
      <div class=\"col-xs-2\">
        <button type=\"button\" class=\"btn btn-danger btn-sm\" (click)=\"removeElement(i)\"><span class=\"oi oi-x\"></span></button>
        <button *ngIf=\"(i == 0)\" type=\"button\" class=\"btn btn-info btn-sm\" (click)=\"unshiftElement()\"><span class=\"oi oi-arrow-thick-top\"></span></button>
        <button *ngIf=\"(elements.controls.length == (i+1))\" type=\"button\" class=\"btn btn-info btn-sm\" (click)=\"pushElement()\"><span class=\"oi oi-arrow-thick-bottom\"></span></button>
      </div>
    </div>
  </div>

  <div *ngIf=\"(elements.controls.length == 0)\" class=\"form-row\">
    <div class=\"col\">
      Orden: <button type=\"button\" class=\"btn btn-info btn-sm\" (click)=\"pushElement()\"><span class=\"oi oi-layers\"></span></button>
    </div>
  </div>
</fieldset>

";
  }
}
