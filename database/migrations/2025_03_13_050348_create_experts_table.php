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
        Schema::create('experts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('specialization')->nullable()->constrained();
            $table->string('experience');
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->string('bio')->nullable();

            // Foreign key
            $table->unsignedBigInteger('litsensiya_id')->nullable();
            $table->foreign('litsensiya_id')
                ->references('id')
                ->on('litsensiyas')
                ->onDelete('SET NULL'); // o‘chirilganda NULL bo‘lishi kerak

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experts');
    }
};
