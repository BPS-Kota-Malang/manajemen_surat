<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->string('nip', 50)->unique();
            $table->string('position', 100)->nullable();
            $table->string('address', 255)->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->string('email', 100)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
