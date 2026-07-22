<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('giveaway_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('giveaway_submissions', 'gift_card_id')) {
                $table->dropForeign(['gift_card_id']);
                $table->dropColumn('gift_card_id');
            }
            if (Schema::hasColumn('giveaway_submissions', 'gift_card_discount')) {
                $table->dropColumn('gift_card_discount');
            }
        });

        Schema::table('giveaway_submissions', function (Blueprint $table) {
            if (!Schema::hasColumn('giveaway_submissions', 'gift_card_type_id')) {
                $table->foreignId('gift_card_type_id')->nullable()->constrained('gift_card_types')->nullOnDelete();
            }
        });

        Schema::dropIfExists('gift_cards');
    }

    public function down(): void
    {
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->decimal('initial_balance', 10, 2);
            $table->decimal('used_balance', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('giveaway_submissions', function (Blueprint $table) {
            $table->dropForeign(['gift_card_type_id']);
            $table->dropColumn('gift_card_type_id');
            $table->foreignId('gift_card_id')->nullable()->constrained('gift_cards')->nullOnDelete();
            $table->decimal('gift_card_discount', 10, 2)->nullable();
        });
    }
};
