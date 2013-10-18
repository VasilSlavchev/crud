<?php namespace Laravella\Crud;

use Laravella\Crud\CrudSeeder;

class PostCrudSeeder extends CrudSeeder {
    
    public function run()
    {
        // change table titles in select lists
        //crud
        $this->tableActionViewId('_db_severities', 'getSelect', 'crud::dbview')->update(array('title'=>'Severities'));
        $this->tableActionViewId('_db_table_action_views', 'getSelect', 'crud::dbview')->update(array('title'=>'Table Action Views'));
        $this->tableActionViewId('_db_tables', 'getSelect', 'crud::dbview')->update(array('title'=>'Tables'));
        $this->tableActionViewId('_db_user_permissions', 'getSelect', 'crud::dbview')->update(array('title'=>'User Permissions'));
        $this->tableActionViewId('_db_usergroup_permissions', 'getSelect', 'crud::dbview')->update(array('title'=>'Usergroup Permissions'));
        $this->tableActionViewId('_db_views', 'getSelect', 'crud::dbview')->update(array('title'=>'Views'));
        $this->tableActionViewId('_db_widget_types', 'getSelect', 'crud::dbview')->update(array('title'=>'Widget Types'));
        $this->tableActionViewId('_db_actions', 'getSelect', 'crud::dbview')->update(array('title'=>'Actions'));
        $this->tableActionViewId('_db_audit', 'getSelect', 'crud::dbview')->update(array('title'=>'Audit'));
        $this->tableActionViewId('_db_display_types', 'getSelect', 'crud::dbview')->update(array('title'=>'Display Types'));
        $this->tableActionViewId('_db_fields', 'getSelect', 'crud::dbview')->update(array('title'=>'Fields'));
        $this->tableActionViewId('_db_logs', 'getSelect', 'crud::dbview')->update(array('title'=>'Logs'));
        $this->tableActionViewId('_db_menu_permissions', 'getSelect', 'crud::dbview')->update(array('title'=>'Menu Permissions'));
        $this->tableActionViewId('_db_menus', 'getSelect', 'crud::dbview')->update(array('title'=>'Menus'));
        $this->tableActionViewId('_db_option_types', 'getSelect', 'crud::dbview')->update(array('title'=>'Option Types'));
        $this->tableActionViewId('_db_options', 'getSelect', 'crud::dbview')->update(array('title'=>'Options'));
        $this->tableActionViewId('_db_keys', 'getSelect', 'crud::dbview')->update(array('title'=>'Keys'));
        $this->tableActionViewId('_db_key_fields', 'getSelect', 'crud::dbview')->update(array('title'=>'Key Fields'));
        $this->tableActionViewId('_db_key_types', 'getSelect', 'crud::dbview')->update(array('title'=>'Key Types'));
        $this->tableActionViewId('_db_objects', 'getSelect', 'crud::dbview')->update(array('title'=>'Objects'));
        
        //hide fields
        $nodisplayId = $this->getId('_db_display_types', 'name', 'nodisplay');
        $this->updateOrInsert('_db_fields', array('fullname'=>'contents.content_mime_type'), array('display_type_id'=>$nodisplayId));
        
        $widgetId = $this->getId('_db_display_types', 'name', 'widget');
        $checkboxId = $this->getId('_db_widget_types', 'name', 'input:checkbox');
        $this->updateOrInsert('_db_fields', array('fullname'=>'medias.approved'), array('display_type_id'=>$widgetId, 'widget_type_id'=>$checkboxId));
        $this->updateOrInsert('_db_fields', array('fullname'=>'medias.publish'), array('display_type_id'=>$widgetId, 'widget_type_id'=>$checkboxId));
        
        //change field titles
        $this->updateOrInsert('_db_fields', array('fullname'=>'contents.lang'), array('label'=>'Language'));
        $this->updateOrInsert('_db_fields', array('fullname'=>'contents.title'), array('display_order'=>'0'));

        $ugId = $this->getId('usergroups', 'group', 'admin');
        $mId = $this->getId('_db_menus', 'label', 'Meta Data');
        $this->delete('_db_menu_permissions', array('usergroup_id'=>$ugId, 'menu_id'=>$mId));
        $mId = $this->getId('_db_menus', 'label', 'Menus');
        $this->delete('_db_menu_permissions', array('usergroup_id'=>$ugId, 'menu_id'=>$mId));
        
    }

}