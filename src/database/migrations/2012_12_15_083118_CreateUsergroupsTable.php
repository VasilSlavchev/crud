<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsergroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('usergroups'))
            {
		Schema::create('usergroups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('group');
			$table->integer('parent_id')->unsigned()->default(0);
			$table->timestamps();
		});
            }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::dropIfExists('usergroups');
	}

}