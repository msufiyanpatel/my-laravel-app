<?php

use App\Models\ConversionHistory;
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
        Schema::create('conversion_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ConversionHistory::class)->onDelete()->cascade()->constrained();
            $table->string('file_name');
            $table->string('file_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversion_lists');
    }
};
