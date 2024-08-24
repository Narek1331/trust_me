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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('link')->nullable();
            $table->text('img_path')->nullable();
            $table->bigInteger('order_by')->default(0);
            $table->timestamps();

            $table->foreign('category_id')
            ->references('id')
            ->on('ad_categories')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
