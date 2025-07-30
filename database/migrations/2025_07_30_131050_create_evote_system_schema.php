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
        Schema::create('voting_events', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->text('deskripsi')->nullable();
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->enum('tipe_vote', ['langsung', 'formatur'])->comment('langsung: 1 pilihan, formatur: >1 pilihan');
            $table->unsignedTinyInteger('maks_pilihan')->default(1)->comment('Jumlah maksimal pilihan untuk tipe formatur');
            $table->enum('status', ['akan datang', 'berlangsung', 'selesai'])->default('akan datang');

            // Foreign key ke user yang membuat event (admin)
            $table->foreignId('id_admin_pembuat')->constrained('users');

            $table->timestamps();
        });

        // 3. Tabel Candidates
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kegiatan')->constrained('voting_events')->cascadeOnDelete();
            $table->string('nama_kandidat');
            $table->unsignedSmallInteger('nomor_urut');
            $table->text('visi_misi')->nullable();
            $table->string('foto_kandidat')->nullable();
            $table->timestamps();

            // Unique constraint untuk nomor urut per kegiatan
            $table->unique(['id_kegiatan', 'nomor_urut']);
        });

        // 4. Tabel Pivot: Activity Participants
        Schema::create('activity_participants', function (Blueprint $table) {
            $table->foreignId('id_kegiatan')->constrained('voting_events')->cascadeOnDelete();
            $table->foreignId('id_pemilih')->constrained('users')->cascadeOnDelete();
            $table->boolean('sudah_memilih')->default(false);
            $table->timestamp('created_at')->nullable();

            // Composite primary key
            $table->primary(['id_kegiatan', 'id_pemilih']);
        });

        // 5. Tabel Votes
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kegiatan')->constrained('voting_events')->cascadeOnDelete();
            $table->foreignId('id_pemilih')->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_kandidat')->constrained('candidates')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
        Schema::dropIfExists('activity_participants');
        Schema::dropIfExists('candidates');
        Schema::dropIfExists('voting_events');
    }
};
