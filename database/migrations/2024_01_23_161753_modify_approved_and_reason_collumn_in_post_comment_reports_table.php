<?php

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
        Schema::table('post_comment_reports', function (Blueprint $table) {
            $table->dropColumn('approved');

            $table->enum('status', [
                'APPROVED',
                'REJECTED',
                'OPEN'
            ])->default('OPEN');

            $table->renameColumn('reason', 'message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_comment_reports', function (Blueprint $table) {
            //
        });
    }
};
