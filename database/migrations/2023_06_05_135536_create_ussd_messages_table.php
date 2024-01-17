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
        Schema::create('ussd_messages', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('msisdn', 12);
            $table->string('session_id');
            $table->foreignId('ussd_activity_id')->constrained();
            $table->string('direction');
            $table->string('message')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ussd_messages');
    }
};