<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->string('task_details')->default('No details provided')->change();
    });
}

public function down()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->string('task_details')->nullable(false)->change();
    });
}

};
