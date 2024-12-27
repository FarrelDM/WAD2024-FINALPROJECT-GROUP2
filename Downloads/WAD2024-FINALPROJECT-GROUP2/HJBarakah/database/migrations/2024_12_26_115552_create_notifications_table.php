<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->json('roles')->nullable(); // Store roles as JSON
            $table->unsignedBigInteger('task_id')->nullable(); // Task association
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade'); // Foreign key to tasks
            $table->timestamp('reminder_time')->nullable(); // Reminder time from task's date
            $table->timestamp('sent_at')->nullable(); // Track when the notification was sent
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
