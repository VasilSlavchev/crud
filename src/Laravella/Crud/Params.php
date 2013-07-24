<?php
namespace Laravella\Crud;
class Params {

    public $action = "";
    public $tableMeta = null;
    public $data = null;
    public $paginated = null;
    public $primaryTables = array();
    public $foreignTables = array();
    public $prefix = "";
    public $tableActionViews = null;
    public $view = null;
    public $selects = array();

    /**
     * 
     * Used to pass a consistent set of data to views and prevent "$variable not found" errors.
     * 
     * @param type $action the action that controller is performing. See _db_actions.name 
     * @param type $tableMeta The table's meta data. As generated by Laravella\Crud\Table::getTableMeta()
     * @param type $data The list of records that will be displayed on screen. Actual data
     * @param type $pageSize. The size of the pagination.
     * @param type $primaryTables A list of records with primary keys related to this table's via foreign keys.
     * @param type $foreignTables A list of records with foreign key constraints related to this table's primary key.
     * @param type $prefix Used to prepend the href on the primary key
     * @param type $view An entry in _db_views
     */
    public function __construct($action, $tableMeta, $data, $paginated, $tableActionViews, 
            $primaryTables = null, $foreignTables = null, $prefix = "", $view, $selects)
    {
        $this->paginated = $paginated;
        $this->action = $action;
        $this->tableMeta = $tableMeta;
        $this->data = $data;
        $this->pageSize = 11;
        $this->primaryTables = $primaryTables;
        $this->foreignTables = $foreignTables;
        $this->prefix = $prefix;
        $this->tableActionViews = $tableActionViews;
        $this->view = $view;
        $this->selects = $selects;
    }

    public function asArray()
    {
        
        $returnA = array("action"=>$this->action,
            "meta"=>$this->tableMeta['fields_array'],
            "data"=>$this->paginated,
            "tableName"=>$this->tableMeta['table']['name'],
            "prefix"=>$this->prefix,
            "pageSize"=>$this->tableActionViews->page_size,
            "pkTables"=>$this->primaryTables,
            "fkTables"=>$this->foreignTables,
            "title"=>$this->tableActionViews->title,
            "view"=>$this->view,
            "selects"=>  $this->selects);
        
        $paramsA = $returnA;
        $paramsA['paginated'] = "-- truncated for size --";
        $paramsA['data'] = "-- truncated for size --";
        
        $returnA['params'] = json_encode($paramsA);
        
        return $returnA;
            
    }

}

?>