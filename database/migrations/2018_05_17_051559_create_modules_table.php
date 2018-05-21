<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->char('module_name',100);
            $table->char('module_icon',100);
            $table->mediumText('description');
            $table->mediumText('home_url');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamps();            
            $table->enum('status',['Active', 'Inactive'])->default('Active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
