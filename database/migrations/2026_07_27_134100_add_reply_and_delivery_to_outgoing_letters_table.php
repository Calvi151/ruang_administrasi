<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->enum('category', ['umum', 'balasan'])->default('umum')->after('letter_number');
            $table->foreignId('incoming_letter_id')->nullable()->after('category')->constrained('incoming_letters')->nullOnDelete();
            $table->string('delivery_method')->nullable()->after('status');
            $table->text('delivery_note')->nullable()->after('delivery_method');
            $table->timestamp('delivered_at')->nullable()->after('delivery_note');
            $table->timestamp('approved_at')->nullable()->after('delivered_at');
        });

        // Extend status enum to include 'delivered'
        try {
            DB::statement("ALTER TABLE outgoing_letters MODIFY COLUMN status ENUM('pending', 'acc', 'reject', 'delivered') NOT NULL DEFAULT 'pending'");
        } catch (\Exception $e) {
            // Ignore if database driver doesn't support modify column directly
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->dropForeign(['incoming_letter_id']);
            $table->dropColumn([
                'category',
                'incoming_letter_id',
                'delivery_method',
                'delivery_note',
                'delivered_at',
                'approved_at'
            ]);
        });

        try {
            DB::statement("ALTER TABLE outgoing_letters MODIFY COLUMN status ENUM('pending', 'acc', 'reject') NOT NULL DEFAULT 'pending'");
        } catch (\Exception $e) {
            //
        }
    }
};
