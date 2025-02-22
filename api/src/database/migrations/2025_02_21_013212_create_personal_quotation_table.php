<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\QuotationModel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('traveler_quotation', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(QuotationModel::class, 'quotation_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('age');
            $table->decimal('age_load_fare', 1, 1);
            $table->decimal('total', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traveler_quotation');
    }
};
