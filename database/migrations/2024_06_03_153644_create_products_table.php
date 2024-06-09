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
//        Schema::create('categories', function (Blueprint $table) {
////            $table->increments('id');
////            $table->unsignedInteger('parent_id')->nullable();
////            $table->string('name');
////            $table->longText('description');
////            $table->timestamps();
//
//            $table->foreign('parent_id')
//                ->references('id')
//                ->on('categories')
//                ->onDelete('cascade');
//        });
//
//        Schema::create('products', function (Blueprint $table) {
//            $table->id();
//            $table->string('product_name');
//            $table->string('product_description');
//            $table->float('product_price');
//            $table->float('product_discount');
//            $table->string('product_image');
//            $table->integer('product_status')->default(1);
//            $table->timestamps();
//            // foreign key
//            $table->unsignedInteger('category_id');
//            $table->foreign('category_id')
//                ->references('id')
//                ->on('categories')
//                ->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
