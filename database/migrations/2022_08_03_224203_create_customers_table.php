<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            //            $table->foreignIdFor(\App\Models\CustomerAddress::class)->constrained()->cascadeOnDelete();
            $table->string('name');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
