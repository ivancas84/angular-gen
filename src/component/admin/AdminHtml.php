<?php

require_once("GenerateFileEntity.php");


class Gen_AdminHtml extends GenerateFileEntity {

  public function __construct(Entity $entity, $directorio = null){
    $file = $entity->getName("xx-yy") . "-admin.component.html";
    if(!$directorio) $directorio = $_SERVER["DOCUMENT_ROOT"]."/".PATH_GEN."/" . "tmp/component/admin/" . $entity->getName("xx-yy") . "-admin/";
    parent::__construct($directorio, $file, $entity);
  }



  public function generateCode() {
    $this->string .= "
<form class=\"container\" [formGroup]=\"adminForm\" (ngSubmit)=\"onSubmit()\" novalidate  autocomplete=\"off\">
  <app-" . $this->getEntity()->getName("xx-yy") . "-fieldset [form]=\"adminForm\" [data\$]=\"data\$\"></app-" . $this->getEntity()->getName("xx-yy") . "-fieldset>
  <button [disabled]=\"adminForm.pending && isSubmitted\" type=\"submit\" class=\"btn btn-primary\">Aceptar</button>&nbsp;
  <button type=\"button\" class=\"btn btn-secondary\" (click)=\"back()\"><span class=\"oi oi-arrow-thick-left\" title=\"Volver\"></span></button>
  <button type=\"button\" (click)=\"reset()\" class=\"btn btn-secondary\" ><span class=\"oi oi-reload\" title=\"Restablecer\"></span></button>
  <button type=\"button\" (click)=\"clear()\" class=\"btn btn-secondary\" ><span title=\"Nuevo\" class=\"oi oi-plus\"></span></button>
  <button type=\"button\" class=\"btn btn-secondary\" [disabled]=\"isDeletable\" (click)=\"delete()\"><span class=\"oi oi-x\" title=\"Eliminar\"></span></button>

  <!--p>Debug Form value: {{ adminForm.value | json }}</p>
  <p>Debug Form status: {{ adminForm.status | json }}</p-->
</form>
";

  }
}
