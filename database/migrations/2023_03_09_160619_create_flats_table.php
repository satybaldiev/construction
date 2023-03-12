<?php

use App\Enum\FlatStatus;
use App\Enum\FlatType;
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
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('area');
            $table->integer('room_count');

            $table->string('price_per_m')->nullable();
            $table->string('currency')->nullable();

            $table->string('real_area')->nullable();
            $table->enum('type', FlatType::getAllValues())->default(FlatType::RESIDENTAL);
            $table->enum('status', FlatStatus::getAllValues())->default(FlatStatus::FREE);

            $table->foreignId('floor_id')->constrained('floors')->onDelete('cascade');
            $table->foreignId('plan_id')->nullable()->constrained('plans')->nullOnDelete();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};
