<?php

/**
 * Controlador para generar el proyecto AngularIoGen
 * Es posible seleccionar la generacion de una determinada interfaz mediante el parametro "gen", ejemplo http://localhost/angular-gen/src/?gen=admin
 */

require_once("../config/config.php");
require_once("class/model/entity/structure.php");
require_once("class/tools/Filter.php");

require_once("gen/service/data-definition-loader/DataDefinitionLoader.php");

$generate = Filter::get("gen");

switch($generate){
    case null: case "loader": loader($structure); break;
}

foreach($structure as $entity){
    switch($generate){
        case null: case "data-definition": data_definition($entity); break;
        case null: case "show": show($entity); break;
        case null: case "admin": admin($entity); break;
        case null: case "fieldset": fieldset($entity); break;


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

function admin(Entity $entity){
    require_once("gen/component/admin/AdminTs.php");
    $gen = new Gen_AdminTs($entity);
    $gen->generate();

    require_once("gen/component/admin/AdminHtml.php");
    $gen = new Gen_AdminHtml($entity);
    $gen->generate();
}

function fieldset(Entity $entity){
    require_once("gen/component/fieldset/FieldsetTs.php");
    $gen = new FieldsetTs($entity);
    $gen->generate();

    require_once("gen/component/fieldset/FieldsetHtml.php");
    $gen = new FieldsetHtml($entity);
    $gen->generate();
}