<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //'facebook', 'phone', 'address', 'avatar', 'coins', 'bod', 'gender', 'status'
            $table->string('facebook', 255)->nullable();
            $table->string('phone', 15)->unique();
            $table->string('address', 255)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->integer('coins')->default(0);
            $table->date('dob');
            $table->tinyInteger('gender')->default(1);
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
