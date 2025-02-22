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
        Schema::create('inboxes', function (Blueprint $table) {
            $table->id('inbox_id');
            $table->string('sender', 100);
            $table->date('date');
            $table->string('status', 50)->nullable();
            $table->integer('code')->nullable();
            $table->string('subject', 255);
            $table->text('content')->nullable();
            $table->string('file', 255)->nullable();
            $table->foreignId('operator_id')->nullable()->constrained('operators', 'operator_id')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inboxes');
    }
};
