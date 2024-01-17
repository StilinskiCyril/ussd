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
        Schema::create('ussd_activities', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('session_id');
            $table->string('msisdn', 12);
            $table->string('activity');
            $table->integer('attempt')->default(0);
            $table->boolean('status')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ussd_activities');
    }
};