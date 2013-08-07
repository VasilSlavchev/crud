<?php

use Laravella\Crud\Log;

class SeedUsers extends Seeder {

    private function __createUser($name, $password, $email, $firstName, $lastName) {
        $hashPass = Hash::make($password);
        
        $group = DB::table('groups')->where('name', 'Admins')->first();
        $userGroup = DB::table('usergroups')->where('group', 'Admins')->first();


        $adminUser = array('username' => $name, 'password' => $hashPass, 'email' => $email); //Config::get('crud::app.setup_user');
        $adminUser['activated'] = true;
        $adminUser['api_token'] = makeApiKey();

        $userId = DB::table('users')->insertGetId($adminUser);

        DB::table('users')->update(array('id' => $userId, 'usergroup_id' => $userGroup->id));
        
        DB::table('users_groups')->insert(array('user_id' => $userId, 'group_id' => $group->id));
        
        return $userId;
        
    }
    
    public function run()
    {
        DB::table('users')->delete();
        
        $password = rand(23450987, 234509870);

        $password = md5($password);
        
        $shortPassword = substr($password,0,8);
        
        //echo ;
        Log::write(Log::INFO, "-- password : $shortPassword --");
        
        //admin ravel 'admin@yourwebsite.com'
        
    }

}

?>