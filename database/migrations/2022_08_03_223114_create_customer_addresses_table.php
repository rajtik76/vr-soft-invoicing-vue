<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();

            $table->string('street_name');
            $table->string('city');
            $table->string('zip_code');
            $table->string('country');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_addresses');
    }
};
