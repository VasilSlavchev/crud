<?php namespace Laravella\Crud;

use Laravella\Crud\Log;
use \Seeder;
use \DB;

class UpdateReferences extends CrudSeeder {

    /**
     * 
     * 
     * @param type $log
     * @throws Exception
     */
    public function run()
    {
        try
        {
            // create foreign key references with
            // log, fkTableName, fkFieldName, pkTableName, pkFieldName, pkDisplayFieldName

            $this->updateReference('_db_fields', 'table_id', '_db_tables', 'id', 'name');
            $this->updateReference('_db_fields', 'pk_field_id', '_db_fields', 'id', 'fullname');
            $this->updateReference('_db_fields', 'pk_display_field_id', '_db_fields', 'id', 'fullname');
            $this->updateReference('_db_fields', 'display_type_id', '_db_display_types', 'id', 'name');
            $this->updateReference('_db_fields', 'widget_type_id', '_db_widget_types', 'id', 'name');

            $this->updateReference('_db_table_action_views', 'view_id', '_db_views', 'id', 'name');
            $this->updateReference('_db_table_action_views', 'table_id', '_db_tables', 'id', 'name');
            $this->updateReference('_db_table_action_views', 'action_id', '_db_actions', 'id', 'name');

            $this->updateReference('users', 'usergroup_id', 'usergroups', 'id', 'group');
            
            $this->updateReference('_db_user_permissions', 'user_id', 'users', 'id', 'username');
            $this->updateReference('_db_user_permissions', 'table_id', '_db_tables', 'id', 'name');
            $this->updateReference('_db_user_permissions', 'action_id', '_db_actions', 'id', 'name');

//            $this->updateReference('_db_usergroup_permissions', 'usergroup_id', 'groups', 'id', 'name');
            $this->updateReference('_db_usergroup_permissions', 'table_id', '_db_tables', 'id', 'name');
            $this->updateReference('_db_usergroup_permissions', 'action_id', '_db_actions', 'id', 'name');
            
            $this->updateReference('_db_menus', 'parent_id', '_db_menus', 'id', 'label');

            $this->updateReference('_db_menu_permissions', 'menu_id', '_db_menus', 'id', 'label');
            $this->updateReference('_db_menu_permissions', 'usergroup_id', 'usergroups', 'id', 'group');
            
            $this->updateReference('medias', 'gallery_id', 'galleries', 'id', 'name');
            $this->updateReference('medias', 'mcollection_id', 'mcollections', 'id', 'name');
            $this->updateReference('medias', 'user_id', 'users', 'id', 'username');

            $this->updateReference('galleries', 'media_id', 'medias', 'id', 'filename');
            
            $this->updateReference('_db_options', 'option_type_id', '_db_option_types', 'id', 'name');
            $this->updateReference('_db_option_types', 'parent_id', '_db_option_types', 'id', 'name');
            
            $this->updateReference('_db_keys', 'field_id', '_db_fields', 'id', 'fullname');
            $this->updateReference('_db_keys', 'key_type_id', '_db_key_types', 'id', 'name');

            $this->updateReference('_db_key_fields', 'field_id', '_db_fields', 'id', 'fullname');
            $this->updateReference('_db_key_fields', 'key_id', '_db_keys', 'id', 'name');
            
            $this->updateReference('contents', 'content_type_id', 'content_types', 'id', 'name');
            
            Log::write("success", "Completed foreign key references");
        }
        catch (Exception $e)
        {
            Log::write("success", "Error while inserting foreign key references.");
            Log::write("success", $e->getMessage());
            throw new Exception($e);
        }
    }

}

?>
