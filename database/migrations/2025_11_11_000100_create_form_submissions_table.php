<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('form_submissions')) {
            Schema::create('form_submissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('form_id');
                $table->longText('submission_data'); // JSON payload
                $table->string('submitted_by')->nullable(); // optional: ip/user agent or user id if needed
                $table->timestamps();

                $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};


