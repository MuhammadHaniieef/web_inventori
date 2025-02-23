<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_out_histories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('division')->nullable();
            $table->foreignId('item_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('tool_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('previous_stock');
            $table->integer('qty');
            $table->integer('new_stock');
            $table->enum('type', ['take', 'loan', 'missing'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_out_histories');
    }
};
