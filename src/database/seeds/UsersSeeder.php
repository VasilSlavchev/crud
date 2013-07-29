<?php

use Laravella\Crud\Log;

class SeedUsers extends Seeder
{


	public function run()
	{
                $password = rand(23450987, 234509870);

                $password = substr(md5($password), 0, 8);

		$adminUser = array('username' => 'admin', 'password' => $password, 'email' => 'admin@yourwebsite.com'); //Config::get('crud::app.setup_user');

		$adminGroup = DB::table('usergroups')->where('group','Admins')->first();

		$adminUser['usergroup_id'] = (int) $adminGroup->id;
		$adminUser['activated'] = true;
		$adminUser['api_token'] = makeApiKey();

		DB::table('users')->delete();
		
		DB::table('users')->insert($adminUser);
		
	}
}
?>