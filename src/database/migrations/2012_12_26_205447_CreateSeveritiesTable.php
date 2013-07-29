<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeveritiesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @access   public
     * @return   void
     */
    public function up()
    {
        if (!Schema::hasTable('_db_severities'))
        {
            Schema::create('_db_severities', function ($table)
                    {
                        $table->increments('id')->unique();
                        $table->string('name', 100)->unique();
                        $table->timestamps();
                    });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @access   public
     * @return   void
     */
    public function down()
    {
        Schema::dropIfExists('_db_severities');
    }

}
