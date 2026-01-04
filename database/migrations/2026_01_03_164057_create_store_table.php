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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();

            // العلاقة مع البائع
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // بيانات المتجر الأساسية
            $table->string('name');                 // اسم المتجر
            $table->string('slug')->unique();       // رابط المتجر في الموقع
            $table->text('description')->nullable();// وصف المتجر

            // الصور
            $table->string('logo')->nullable();     // لوجو المتجر
            $table->string('cover_image')->nullable(); // صورة الغلاف

            // العنوان

            $table->string('address')->nullable();

            // وسائل التواصل
            $table->string('phone')->nullable();

            $table->string('facebook')->nullable();

            $table->string('whatsapp')->nullable();

            // حالة المتجر
            $table->boolean('is_active')->default(true);
            $table->time('open_time')->nullable();   // وقت الفتح
            $table->time('close_time')->nullable();  // وقت الإغلاق

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
