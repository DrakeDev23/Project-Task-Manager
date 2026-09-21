<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_email_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->date('notified_for');
            $table->timestamps();
            $table->unique(['task_id', 'type', 'notified_for']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_email_notifications');
    }
};
