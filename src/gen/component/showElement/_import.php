<?php

require_once("generate/GenerateEntity.php");


class GenShowElementTs_import extends GenerateEntity {


  public function generate() {
    $this->string .= "import { Component } from '@angular/core';
import { ShowElementComponent } from '@component/show-element/show-element.component';
import { DataDefinitionService } from '@service/data-definition/data-definition.service';
import { isEmptyObject } from '@function/is-empty-object.function';
import { forkJoin } from 'rxjs';

";
    return $this->string;
  }


}
