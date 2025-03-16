<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_templates', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('headline');
            $table->string('message'); // must be at least ->text() if we expect it to be more than 255 symbols
            $table->string('link');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_templates');
    }
};
