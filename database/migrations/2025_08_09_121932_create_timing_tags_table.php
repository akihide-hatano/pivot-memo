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
        Schema::create('timing_tags', function (Blueprint $table) {
            $table->id();
            $table->string('timing_name');
            //ユニーク制約で重複登録されないようにする
            $table->unique('timing_name');
            $table->time('base_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timing_tags');
    }
};
