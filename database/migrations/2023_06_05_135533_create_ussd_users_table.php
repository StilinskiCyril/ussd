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
        Schema::create('ussd_users', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('msisdn', 12);
            $table->string('locale')->default('en');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ussd_users');
    }
};