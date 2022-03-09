<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('order_no')->unique();
            $table->unsignedInteger('ad_user_id');
            $table->string('user_name');
            $table->unsignedInteger('campaign_id');
            $table->string('campaign_name');
            $table->unsignedInteger('doctype_id');
            $table->string('doctype_name');
            $table->unsignedInteger('customer_id');
            $table->string('customer_name');
            $table->unsignedInteger('location_id');
            $table->string('location_name');
            $table->unsignedInteger('warehouse_id');
            $table->string('warehouse_name');
            $table->unsignedInteger('pricelist_id');
            $table->date('date_ordered');
            $table->foreignId('user_id')->constrained();
            $table->string('c_order_id')->nullable();
            $table->string('c_order_no')->nullable();
            $table->unsignedInteger('grandtotal')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
