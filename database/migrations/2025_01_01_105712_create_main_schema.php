<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
    // Create 'application' table
    Schema::create('application', function (Blueprint $table) {
        $table->id('app_id');
        $table->string('username');
        $table->string('app_secret');
        $table->timestamps();
    });

    // Create 'device' table
    Schema::create('device', function (Blueprint $table) {
        $table->id('device_id');
        $table->string('mac_address', 12); // only the characters. No colons or dashes!
        $table->string('location');
        $table->unsignedBigInteger('mother_app')->nullable();
        $table->foreign('mother_app')->references('app_id')->on('application')->onDelete('set null');
        $table->timestamps();
    });

    // Create 'device_apps' pivot table
    Schema::create('device_apps', function (Blueprint $table) {
        $table->unsignedBigInteger('device_id');
        $table->unsignedBigInteger('app_id');
        $table->primary(['device_id', 'app_id']);
        $table->foreign('device_id')->references('device_id')->on('device')->onDelete('cascade');
        $table->foreign('app_id')->references('app_id')->on('application')->onDelete('cascade');
    });

    // Create 'routine' table
    Schema::create('routine', function (Blueprint $table) {
        $table->id('routine_id');
        $table->text('description');
        $table->integer('frequency');
        $table->date('last_done')->nullable();
        $table->timestamps();
    });

    // Create 'task' table
    Schema::create('task', function (Blueprint $table) {
        $table->id('task_id');
        $table->string('title');
        $table->text('description');
        $table->timestamps();
    });

    // Create 'routine_task' pivot table
    Schema::create('routine_task', function (Blueprint $table) {
        $table->unsignedBigInteger('routine_id');
        $table->unsignedBigInteger('task_id');
        $table->primary(['routine_id', 'task_id']);
        $table->foreign('routine_id')->references('routine_id')->on('routine')->onDelete('cascade');
        $table->foreign('task_id')->references('task_id')->on('task')->onDelete('cascade');
    });

    // Create 'maintenance_history' table
    Schema::create('maintenance_history', function (Blueprint $table) {
        $table->id('history_id');
        $table->unsignedBigInteger('routine_id');
        $table->boolean('completed');
        $table->foreign('routine_id')->references('routine_id')->on('routine')->onDelete('cascade');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('maintenance_history');
        Schema::dropIfExists('routine_task');
        Schema::dropIfExists('task');
        Schema::dropIfExists('routine');
        Schema::dropIfExists('device_apps');
        Schema::dropIfExists('device');
        Schema::dropIfExists('application');
    }
};
