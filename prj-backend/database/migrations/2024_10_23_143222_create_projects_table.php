<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\ProjectStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class, 'maintainer_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class, 'executor_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('title')->unique();
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['created', 'in_progress', 'completed'])->default('created');
            $table->integer('remaining_days')->nullable(); // Остаток дней до окончания
            $table->timestamps();

            $table->check('end_date >= start_date'); // Ограничение на корректность дат
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
