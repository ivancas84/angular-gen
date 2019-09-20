<?php

//controlador para generar el proyecto AngularIoGen

//configuracion general
require_once("../config/config.php"); //configuracion
require_once("class/model/entity/structure.php");


require_once("gen/service/data-definition-loader/DataDefinitionLoader.php");
$gen = new DataDefinitionLoaderService($structure);
$gen->generate();

foreach($structure as $entity){
    require_once("gen/class/data-definition/_DataDefinition.php");
    $gen = new _ClassDataDefinition($entity);
    $gen->generate();

    require_once("gen/class/data-definition/DataDefinition.php");
    $gen = new ClassDataDefinition($entity);
    $gen->generateIfNotExists();
}
