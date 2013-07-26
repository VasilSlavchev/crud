<?php

use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @access   public
	 * @return   void
	 */
	public function up()
	{
	        Schema::create('_db_actions', function ($table)
                {
                    $table->increments('id')->unique();
                    $table->string('name', 100);
                    $table->timestamps();                    
                    
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @access   public
	 * @return   void
	 */
	public function down()
	{
		Schema::drop('_db_actions');
	}
}