<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('report_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->string('file_path');          // path to stored file
            $table->string('file_type')->nullable(); // e.g., 'image', 'video'
            $table->timestamps();

            $table->index('report_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_attachments');
    }
}