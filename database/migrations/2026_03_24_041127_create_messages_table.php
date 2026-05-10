<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); // sender (citizen or admin)
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index('report_id');
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}