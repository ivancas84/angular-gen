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

switch($generate) {
    case null: case "loader": loader($structure); break;
}

foreach($structure as $entity) {
    switch($generate){
        //services
        case "data-definition": data_definition($entity); break;
        
        //components
        case "show": show($entity); break;
        case "admin": admin($entity); break;
        case "detail": detail($entity); break;
        case "card": card($entity); break;
        case "fieldset": fieldset($entity); break;
        case "table": table($entity); break;
        case "search": search($entity); break;
        
        case null:
            //services
            data_definition($entity);
            
            //components
            search($entity);
            show($entity);
            admin($entity);
            fieldset($entity);
            table($entity);
            detail($entity);
            card($entity);

        break;
        
    }
}

function loader(array $structure) {
    $gen = new DataDefinitionLoaderService($structure);
    $gen->generate();
}

function data_definition(Entity $entity) {
    require_once("gen/class/data-definition/_DataDefinition.php");
    $gen = new _ClassDataDefinition($entity);
    $gen->generate();

    require_once("gen/class/data-definition/DataDefinition.php");
    $gen = new ClassDataDefinition($entity);
    $gen->generateIfNotExists();
}

function show(Entity $entity) {
    require_once("gen/component/show/ShowTs.php");
    $gen = new Gen_ShowTs($entity);
    $gen->generate();

    require_once("gen/component/show/ShowHtml.php");
    $gen = new Gen_ShowHtml($entity);
    $gen->generate();
}

function admin(Entity $entity) {
    require_once("gen/component/admin/AdminTs.php");
    $gen = new Gen_AdminTs($entity);
    $gen->generate();

    require_once("gen/component/admin/AdminHtml.php");
    $gen = new Gen_AdminHtml($entity);
    $gen->generate();
}

function detail(Entity $entity) {
    require_once("gen/component/detail/DetailTs.php");
    $gen = new Gen_DetailTs($entity);
    $gen->generate();

    require_once("gen/component/detail/DetailHtml.php");
    $gen = new Gen_DetailHtml($entity);
    $gen->generate();
}

function card(Entity $entity) {
    require_once("gen/component/card/CardTs.php");
    $gen = new GenCardTs($entity);
    $gen->generate();

    require_once("gen/component/card/CardHtml.php");
    $gen = new GenCardHtml($entity);
    $gen->generate();
}

function fieldset(Entity $entity) {
    require_once("gen/component/fieldset/FieldsetTs.php");
    $gen = new FieldsetTs($entity);
    $gen->generate();

    require_once("gen/component/fieldset/FieldsetHtml.php");
    $gen = new FieldsetHtml($entity);
    $gen->generate();
}

function table(Entity $entity) {
    require_once("gen/component/table/TableTs.php");
    $gen = new TableTs($entity);
    $gen->generate();

    require_once("gen/component/table/TableHtml.php");
    $gen = new TableHtml($entity);
    $gen->generate();
}

function search(Entity $entity) {
    require_once("gen/component/search/SearchTs.php");
    $gen = new Gen_SearchTs($entity);
    $gen->generate();

    require_once("gen/component/search/SearchHtml.php");
    $gen = new Gen_SearchHtml($entity);
    $gen->generate();
}