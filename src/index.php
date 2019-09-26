<?php

//controlador para generar el proyecto AngularIoGen

//configuracion general
require_once("../config/config.php"); //configuracion
require_once("class/model/entity/structure.php");


require_once("gen/service/data-definition-loader/DataDefinitionLoader.php");


$generate = Filter::get("gen");

switch($generate){
    case null: case "loader": loeader($structure); break;
}

foreach($structure as $entity){
    switch($generate){
        case null: case "data-definition": data_definition($entity); break;
        case null: case "show": show($entity); break;
    } 
}


function loader(Entity $structure){
    $gen = new DataDefinitionLoaderService($structure);
    $gen->generate();
}

function data_definition(Entity $entity){
    require_once("gen/class/data-definition/_DataDefinition.php");
    $gen = new _ClassDataDefinition($entity);
    $gen->generate();

    require_once("gen/class/data-definition/DataDefinition.php");
    $gen = new ClassDataDefinition($entity);
    $gen->generateIfNotExists();
}

function show(Entity $entity){
    require_once("gen/component/show/ShowTs.php");
    $gen = new Gen_ShowTs($entity);
    $gen->generate();

    require_once("gen/component/show/ShowHtml.php");
    $gen = new Gen_ShowHtml($entity);
    $gen->generate();
}