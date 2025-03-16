<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();

            $table->foreignId('partner_id');
            $table->foreignId('post_template_id');

            $table->string('title');
            $table->string('headline');
            $table->string('message'); // must be at least ->text() if we expect it to be more than 255 symbols
            $table->string('link');

            $table->foreign('partner_id')
                ->references('id')
                ->on('partners')
                ->onDelete('cascade'); // must be 'set null' if we need to save the data

            $table->foreign('post_template_id')
                ->references('id')
                ->on('post_templates')
                ->onDelete('cascade'); // must be 'set null' if we need to save the data
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
