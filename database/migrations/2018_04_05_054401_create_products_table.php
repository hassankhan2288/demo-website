<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('code');
            $table->string('type');
            $table->integer('brand_id')->nullable();
            $table->integer('category_id');
            $table->string('pack_size')->nullable();
            $table->double('cost');
            $table->double('price');
            $table->double('p_price');
            $table->double('qty')->nullable();
            $table->double('alert_quantity')->nullable();
            $table->tinyInteger('collection')->nullable();
            $table->tinyInteger('delivery')->nullable();
            $table->integer('tax_id')->nullable();
            $table->integer('tax_method')->nullable();
            $table->longText('image')->nullable();
            $table->text('product_details')->nullable();
            $table->text('packing_info')->nullable();
            $table->text('ingredients')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
