<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::dropIfExists('task_spent_times');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('customer_addresses');
    }
};
