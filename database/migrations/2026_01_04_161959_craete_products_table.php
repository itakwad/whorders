<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. الجدول الأساسي للمنتجات
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. جدول الأسعار حسب الحجم (تظل كما هي مرتبطة بالمنتج)
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('size_name');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        // 3. جدول الإضافات العام للمتجر (هنا التغيير)
        Schema::create('extras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // مثال: صوص حار، جبنة زيادة
            $table->decimal('price', 10, 2)->default(0);
            $table->string('image')->nullable();

            $table->timestamps();
        });

        // 4. جدول الوسيط لربط الإضافة بالمنتجات
        Schema::create('extra_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('extra_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extra_product');
        Schema::dropIfExists('extras');
        Schema::dropIfExists('product_variations');
        Schema::dropIfExists('products');
    }
};
