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
        //
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // ربط التصنيف بالمتجر
            $table->foreignId('store_id')
                ->constrained('stores')
                ->cascadeOnDelete();
            $table->string('name');           // اسم التصنيف (مثلاً: مقبلات، بيتزا، ملابس رجالي)
            $table->string('slug');           // للرابط (URL)
            $table->integer('sort_order')->default(0); // لترتيب ظهور التصنيفات في صفحة المتجر
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('categories');

    }
};
