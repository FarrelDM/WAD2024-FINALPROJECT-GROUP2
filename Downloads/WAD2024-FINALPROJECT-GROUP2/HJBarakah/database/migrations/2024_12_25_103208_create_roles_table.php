<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->string('name'); // The role name
            $table->timestamps();  // Timestamps for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
            $table->dropColumn('name');  // Drop the 'name' column
    }
}