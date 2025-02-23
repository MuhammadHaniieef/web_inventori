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
        Schema::create('stock_in_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->nullable()->constrained('items', 'id')->onDelete('cascade');
            $table->foreignId('tool_id')->nullable()->constrained('tools', 'id')->onDelete('cascade');
            $table->integer('previous_stock')->nullable();
            $table->integer('qty');
            $table->integer('new_stock');
            $table->enum('type', ['new', 'update'])->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in_histories');
    }
};
