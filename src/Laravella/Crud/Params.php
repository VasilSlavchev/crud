<?php namespace Laravella\Crud;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * 
 * Used to pass a consistent set of data to views and prevent "$variable not found" errors.
 * 
 */
class Params {

    public $action = "";
    public $tableMeta = null;
    public $tables = null;
    public $dataA = array();
    public $paginated = null;
    public $primaryTables = array();
    public $prefix = "";
    public $tableActionViews = null;
    public $view = null;
    public $selects = array();
    public $log = array();
    public $status = "success";
    public $displayType = "text/html";
    public $displayTypes = array();
    public $menu = array();

    /**
     * 
     * Used to pass a consistent set of data to views and prevent "$variable not found" errors.
     * 
     * @param type $status Wether the action succeeded or not.  See log for further details.
     * @param type $action the action that controller is performing. See _db_actions.name 
     * @param type $tableMeta The table's meta data. As generated by Laravella\Crud\Table::getTableMeta()
     * @param type $tables Is an array of Table objects. Actual data.
     * @param type $pageSize. The size of the pagination.
     * @param type $primaryTables A list of records with primary keys related to this table's via foreign keys.
     * @param type $prefix Used to prepend the href on the primary key
     * @param type $view An entry in _db_views
     */
    public function __construct($status, $message, $log, $view = null, $action = "", $tableMeta = null, $tableActionViews = null, $prefix = "", $selects = null, $displayType = "", $dataA = array(), $tables = array(), $paginated = array(), $primaryTables = array())
    {
        $this->status = $status;
        $this->message = $message;
        $this->action = $action;
        $this->tableMeta = $tableMeta;
        if (is_object($view))
        {
            $this->pageSize = $view->page_size;
        }
        else
        {
            $this->pageSize = 10;
        }
        $this->prefix = $prefix;
        $this->tableActionViews = $tableActionViews;
        $this->view = $view;
        $this->selects = $selects;
        $this->displayType = $displayType;
        $this->log = $log;
        //potentially null
        $this->paginated = $paginated;
        $this->tables = $tables;
        $this->primaryTables = $primaryTables;
        $this->dataA = $dataA;
        $this->displayTypes = $this->__getDisplayTypes();

        if (Auth::check())
        {
            $userId = Auth::user()->id;
            $this->menu = $this->__getMenu($userId);
        }
    }

    private function __getDisplayTypes() {
        $displayTypes = DB::table('_db_display_types')->get();
        $dtA = array();
        foreach($displayTypes as $displayType) {
            $dtA[$displayType->id] = $displayType->name;
        }
        return $dtA;
    }
    
    /**
     * Build a menu array from _db_menus
     * 
     * @param type $userId
     * @return type
     */
    private function __getMenu($userId)
    {
        $menus = DB::table('users as u')->join('usergroups as ug', 'u.usergroup_id', '=', 'ug.id')
                ->join('_db_menu_permissions as mp', 'mp.usergroup_id', '=', 'ug.id')
                ->join('_db_menus as m', 'm.id', '=', 'mp.menu_id')
                ->join('_db_menus as m2', 'm2.parent_id', '=', 'm.id')
                ->where('u.id', '=', $userId)
                ->select('u.username', 'ug.group', 
                        'm.id', 'm.icon_class', 'm.label', 'm.href', 'm.parent_id', 
                        'm2.id as m2_id', 'm2.icon_class as m2_icon_class', 'm2.label as m2_label', 
                        'm2.href as m2_href', 'm2.parent_id as m2_parent_id')->get();

        $menuA = array();
        foreach($menus as $menu) {
            if (!isset($menuA[$menu->label])) {
                $menuA[$menu->label] = array();
            }
            $menuA[$menu->label][] = array('username'=>$menu->username, 'group'=>$menu->group, 
                'id'=>$menu->id, 'icon_class'=>$menu->icon_class, 'label'=>$menu->label, 
                'href'=>$menu->href, 'parent_id'=>$menu->parent_id, 'm2_id'=>$menu->m2_id, 
                'm2_icon_class'=>$menu->m2_icon_class, 'm2_label'=>$menu->m2_label, 
                'm2_href'=>$menu->m2_href, 'm2_parent_id'=>$menu->m2_parent_id);
        }
        return $menuA;
    }

    /**
     * For Edit
     * 
     * @param type $status
     * @param type $message
     * @param type $log
     * @param type $view
     * @param type $action
     * @param type $tableMeta
     * @param type $tableActionViews
     * @param type $prefix
     * @param type $selects
     * @param type $tables
     * @param type $paginated
     * @param type $primaryTables
     * @return \Laravella\Crud\Params
     */
    public static function forEdit($status, $message, $log, $view = null, $action = "", $tableMeta = null, $tableActionViews = null, $prefix = "", $selects = null, $displayType = "text/html", $tables = null, $paginated = null, $primaryTables = null)
    {
        $params = new Params();
        return $params;
    }

    /*
     * meta
     * data
     * name
     * pagesize
     * selects
     */

    public function asArray()
    {

        $returnA = array("action" => $this->action,
            "meta" => $this->tableMeta['fields_array'],
            "tableName" => $this->tableMeta['table']['name'],
            "prefix" => $this->prefix,
            "pageSize" => $this->pageSize,
            "view" => $this->view,
            "selects" => $this->selects,
            "log" => $this->log,
            "status" => $this->status,
            "message" => $this->message,
            "pkName" => $this->tableMeta['table']['pk_name'],
            "displayType" => $this->displayType,
            "tables" => $this->tables,
            "data" => $this->paginated,
            "dataA" => $this->dataA,
            "pkTables" => $this->primaryTables,
            "menu" => $this->menu,
            "displayTypes" => $this->displayTypes
        ); //$this->tables[$tableName]['tableMetaData']['table']['pk_name']);

        if (isset($this->tableActionViews) && is_object($this->tableActionViews))
        {
            $returnA["title"] = $this->tableActionViews->title;
        }
        else
        {
            $returnA["title"] = "";
        }

        $returnA['params'] = json_encode($returnA);

        return $returnA;
    }

}

?>
