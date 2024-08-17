<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('search')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('review_type_id');
            $table->unsignedBigInteger('check_id');
            $table->bigInteger('parent_id')->nullable();
            $table->longText('text')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('review_type_id')
            ->references('id')
            ->on('review_types')
            ->onDelete('cascade');

            $table->foreign('check_id')
            ->references('id')
            ->on('checks')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
