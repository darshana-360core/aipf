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
        // Schema::create('single_token_stake_plan_setting', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('planname', 100);
        //     $table->decimal('daily_bonus_rate', 10, 2);
        //     $table->integer('dora_count_for_bonus');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('single_token_stake_plan_setting');
    }
};
