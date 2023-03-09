<?php

use App\Enum\AgreementStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('flat_id')->constrained('flats')->onDelete('cascade');
            $table->enum('status', AgreementStatus::getAllValues());
            $table->float('price');
            $table->float('price_per_m');
            $table->string('currency');
            $table->float('exchange_rate');
            $table->boolean('fixed_rate')->default(false);
            $table->date('completion_date')->nullable();
            $table->float('first_installment');
            $table->float('installment_count');
            $table->enum('payment_frequency_month', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])->nullable();
            $table->text('note')->nullable();
            $table->string('agreement_no')->nullable();
            $table->date('date');
            $table->boolean('fully_paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
