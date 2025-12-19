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
        Schema::table('bookings', function (Blueprint $table) {
            // Penyerahan Kunci (Pickup)
            $table->boolean('kunci_diserahkan')->default(false);
            $table->dateTime('tanggal_serah_kunci')->nullable();
            $table->unsignedBigInteger('petugas_serah_kunci_id')->nullable();
            $table->string('foto_serah_kunci')->nullable();
            $table->text('catatan_serah_kunci')->nullable();
            $table->text('tanda_tangan_customer')->nullable();
            
            // Pengembalian Kunci (Return)
            $table->boolean('kunci_dikembalikan')->default(false);
            $table->dateTime('tanggal_terima_kunci')->nullable();
            $table->unsignedBigInteger('petugas_terima_kunci_id')->nullable();
            $table->string('foto_terima_kunci')->nullable();
            $table->text('catatan_terima_kunci')->nullable();
            
            // Foreign keys
            $table->foreign('petugas_serah_kunci_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('petugas_terima_kunci_id')->references('id')->on('users')->onDelete('set null');
            
            // Indexes untuk performance
            $table->index('kunci_diserahkan');
            $table->index('kunci_dikembalikan');
            $table->index('tanggal_serah_kunci');
            $table->index('tanggal_terima_kunci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['petugas_serah_kunci_id']);
            $table->dropForeign(['petugas_terima_kunci_id']);
            
            // Drop indexes
            $table->dropIndex(['kunci_diserahkan']);
            $table->dropIndex(['kunci_dikembalikan']);
            $table->dropIndex(['tanggal_serah_kunci']);
            $table->dropIndex(['tanggal_terima_kunci']);
            
            // Drop columns
            $table->dropColumn([
                'kunci_diserahkan',
                'tanggal_serah_kunci',
                'petugas_serah_kunci_id',
                'foto_serah_kunci',
                'catatan_serah_kunci',
                'tanda_tangan_customer',
                'kunci_dikembalikan',
                'tanggal_terima_kunci',
                'petugas_terima_kunci_id',
                'foto_terima_kunci',
                'catatan_terima_kunci',
            ]);
        });
    }
};
