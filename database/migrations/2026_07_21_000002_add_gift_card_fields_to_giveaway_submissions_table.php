<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('giveaway_submissions', function (Blueprint $table) {
            $table->foreignId('gift_card_id')->nullable()->constrained('gift_cards')->nullOnDelete();
            $table->string('gift_card_code', 50)->nullable();
            $table->decimal('gift_card_discount', 10, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('giveaway_submissions', function (Blueprint $table) {
            $table->dropForeign(['gift_card_id']);
            $table->dropColumn(['gift_card_id', 'gift_card_code', 'gift_card_discount']);
        });
    }
};
