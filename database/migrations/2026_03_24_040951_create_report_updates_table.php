<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportUpdatesTable extends Migration
{
    public function up()
    {
        Schema::create('report_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); // who made the update (admin or system)
            $table->string('status')->nullable(); // the status after the update
            $table->text('notes')->nullable(); // admin comment / details
            $table->timestamps();

            $table->index('report_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_updates');
    }
}