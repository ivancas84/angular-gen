<?php

class GenerateService {

  protected $structure;

  public function __construct(array $structure) {
    $this->structure = $structure;
  }

  public function generate(){
    $this->loader($this->structure);

    foreach($this->structure as $entity){
      $this->entityDataDefinition($entity);

    }
      //***** componentes *****

      /*$this->componentDetail();
      $this->componentAdminModal();
      $this->componentAdminSimple();
      $this->componentFieldsetFields();
      $this->componentFieldsetAdd();
      $this->componentFieldsetRows();
      $this->componentGrid();
      $this->componentGridSearch();
      $this->componentImportCsv();
      $this->componentImportText();
      $this->componentGridRows();
      $this->componentGrid();*/
    }

    protected function entityDataDefinition($entity){
      require_once("angulariogen/service/data-definition/entity-data-definition/EntityDataDefinitionMain.php");
      $gen = new EntityDataDefinitionMain($entity);
      $gen->generate();

      require_once("angulariogen/service/data-definition/entity-data-definition/EntityDataDefinition.php");
      $gen = new EntityDataDefinition($entity);
      $gen->generateIfNotExists();
    }

    protected function loader($entity){
      require_once("angulariogen/service/loader/Loader.php");
      $gen = new LoaderService($entity);
      $gen->generate();
    }



  protected function componentGridSearch(){
    require_once("component/gridSearch/Template.php");
    $gen = new GridSearchTemplate($this->entity);
    $gen->generate();
  }

  protected function componentDetail(){
    require_once("component/detail/Template.php");
    $gen = new DetailTemplate($this->entity);
    $gen->generate();
  }


  protected function componentAdminSimple(){
    require_once("component/AdminSimple/Controller.php");
    $gen = new AdminSimpleController($this->entity);
    $gen->generate();

    require_once("component/AdminSimple/Template.php");
    $gen = new AdminSimpleTemplate($this->entity);
    $gen->generate();
  }

  protected function componentAdminModal(){
    require_once("component/AdminModalSimple/Controller.php");
    $gen = new AdminModalSimpleController($this->entity);
    $gen->generate();

    require_once("component/AdminModalSimple/Template.php");
    $gen = new AdminModalSimpleTemplate($this->entity);
    $gen->generate();
  }

  protected function componentFieldsetFields(){
    require_once("component/fieldsetFields/Template.php");
    $gen = new FieldsetFieldsTemplate($this->entity);
    $gen->generate();
  }





  protected function componentFieldsetAdd(){
    require_once("component/fieldsetAdd/Template.php");
    $gen = new FieldsetAddTemplate($this->entity);
    $gen->generate();

  }



  protected function componentGridRows(){
    require_once("component/gridRows/Template.php");
    $gen = new GridRowsRowTemplate($this->entity);
    $gen->generate();
  }

  protected function componentGrid(){
    require_once("component/Grid/Controller.php");
    $gen = new GridController($this->entity);
    $gen->generate();

    require_once("component/Grid/Template.php");
    $gen = new GridTemplate($this->entity);
    $gen->generate();
  }


  protected function componentFieldsetRows(){
    require_once("component/fieldsetRows/Template.php");
    $gen = new FieldsetRowsTemplate($this->entity);
    $gen->generate();
  }



  protected function componentImportCsv(){
    require_once("component/importCsv/Controller.php");
    $gen = new ImportCsvController($this->entity);
    $gen->generate();
  }

  protected function componentImportText(){
    require_once("component/importText/Controller.php");
    $gen = new ImportTextController($this->entity);
    $gen->generate();
  }


  //***** MODELO *****


  protected function sqlo(){
    require_once("phpdbgen/sqlo/core.php");
    $gen = new ClassSqloMain($this->entity);
    $gen->generate();

    require_once("phpdbgen/sqlo/Sql.php");
    $gen = new ClassSqlo($this->entity);
    $gen->generate();
  }

  protected function sql(){
    require_once("phpdbgen/sql/Sql.php");
    $gen = new GenerateClassSql($this->entity);
    $gen->generate();

    require_once("phpdbgen/sql/core.php");
    $gen = new GenerateClassSqlMain($this->entity);
    $gen->generate();

  }

  protected function values(){
    require_once("phpdbgen/values/core.php");
    $gen = new ClassValuesMain($this->entity);
    $gen->generate();

    require_once("phpdbgen/values/Imp.php");
    $gen = new ClassValuesImp($this->entity);
    $gen->generate();


  }


  //***** OBSOLETO: REFACTORIZAR ******

  protected function fieldsetDetailHtml(){
    require_once("html/fieldset/Detail.php");
    $gen = new GenerateHtmlFieldsetDetail($this->entity);
    $gen->generate();
  }

  protected function fieldsetGridRowsHtml(){
    require_once("html/fieldset/UmDetail.php");
    $gen = new GenerateHtmlFieldsetGridRows($this->entity);
    $gen->generate();
  }

  protected function fieldsetDetailRowController(){
    require_once("angular/controller/fieldset/detailRow/Detail.php");
    $gen = new GenerateControllerFieldsetDetail($this->entity);
    $gen->generate();
  }

  protected function fieldsetGridRowsRowController(){
    require_once("angular/controller/fieldset/umdetail/UmDetail.php");
    $gen = new GenerateControllerFieldsetGridRows($this->entity);
    $gen->generate();
  }







}
