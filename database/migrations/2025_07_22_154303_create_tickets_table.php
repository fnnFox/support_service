<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

			$table->string('title');
			$table->text('description');
			$table->string('category');

			$table->enum('priority',['low','medium','high'])->default('medium');
			$table->enum('status',['open','in_progress','closed'])->default('open');

			$table->foreignId('created_by')->constrained('users')->onDelete('cascade');
			$table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null');

			$table->index('created_by');
			$table->index('assigned_by');
			$table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
