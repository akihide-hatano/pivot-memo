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
        Schema::create('record_medication', function (Blueprint $table) {
            $table->id();

            $table->foreignId('record_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medication_id')->constrained()->cascadeOnDelete();

            // 追加情報（pivot用）
            $table->string('taken_dosage'); // 服用量
            $table->boolean('is_completed')->default(false);
            $table->string('reason_not_taken')->nullable(); // 未服用の理由

            $table->timestamps();

            // 複合ユニーク制約（同じ記録に同じ薬を重複登録しない）
            $table->unique(['record_id', 'medication_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('record_medication');
    }
};
