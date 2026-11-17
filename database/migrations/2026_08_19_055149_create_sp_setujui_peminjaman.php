<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared(
            'DROP PROCEDURE IF EXISTS sp_setujui_peminjaman'
        );

        DB::unprepared("
            CREATE PROCEDURE sp_setujui_peminjaman(
                IN p_peminjaman_id BIGINT UNSIGNED,
                IN p_petugas_id BIGINT UNSIGNED
            )
            BEGIN
                DECLARE v_selesai INT DEFAULT 0;
                DECLARE v_alat_id INT UNSIGNED;
                DECLARE v_jumlah INT;
                DECLARE v_tersedia INT;
                DECLARE v_nama_alat VARCHAR(150);
                DECLARE v_status VARCHAR(30);
                DECLARE v_pesan VARCHAR(255);
                DECLARE v_kode VARCHAR(20);

                /*
                |--------------------------------------------------------------------------
                | CURSOR DETAIL PEMINJAMAN
                |--------------------------------------------------------------------------
                */

                DECLARE kursor_detail CURSOR FOR
                    SELECT alat_id, jumlah
                    FROM detail_peminjaman
                    WHERE peminjaman_id = p_peminjaman_id;

                DECLARE CONTINUE HANDLER FOR NOT FOUND
                    SET v_selesai = 1;


                /*
                |--------------------------------------------------------------------------
                | 1. CEK DATA PEMINJAMAN
                |--------------------------------------------------------------------------
                */

                SELECT status, kode_pinjam
                INTO v_status, v_kode
                FROM peminjaman
                WHERE id = p_peminjaman_id;


                /*
                |--------------------------------------------------------------------------
                | 2. CEK PEMINJAMAN DITEMUKAN
                |--------------------------------------------------------------------------
                */

                IF v_status IS NULL THEN

                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT =
                        'Data peminjaman tidak ditemukan';

                END IF;


                /*
                |--------------------------------------------------------------------------
                | 3. STATUS HARUS DIAJUKAN
                |--------------------------------------------------------------------------
                */

                IF v_status <> 'diajukan' THEN

                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT =
                        'Peminjaman ini sudah pernah diproses';

                END IF;


                /*
                |--------------------------------------------------------------------------
                | 4. BUKA CURSOR DETAIL
                |--------------------------------------------------------------------------
                */

                OPEN kursor_detail;


                proses_detail: LOOP

                    FETCH kursor_detail
                    INTO v_alat_id, v_jumlah;


                    /*
                    |--------------------------------------------------------------------------
                    | Jika semua detail sudah selesai
                    |--------------------------------------------------------------------------
                    */

                    IF v_selesai = 1 THEN

                        LEAVE proses_detail;

                    END IF;


                    /*
                    |--------------------------------------------------------------------------
                    | 5. AMBIL NAMA DAN STOK TERSEDIA ALAT
                    |--------------------------------------------------------------------------
                    */

                    SELECT nama, stok_tersedia
                    INTO v_nama_alat, v_tersedia
                    FROM alat
                    WHERE id = v_alat_id
                    FOR UPDATE;


                    /*
                    |--------------------------------------------------------------------------
                    | 6. CEK ALAT
                    |--------------------------------------------------------------------------
                    */

                    IF v_tersedia IS NULL THEN

                        CLOSE kursor_detail;

                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT =
                            'Alat tidak ditemukan';

                    END IF;


                    /*
                    |--------------------------------------------------------------------------
                    | 7. CEK STOK TERSEDIA
                    |--------------------------------------------------------------------------
                    */

                    IF v_tersedia < v_jumlah THEN

                        CLOSE kursor_detail;

                        SET v_pesan = CONCAT(
                            'Stok alat ',
                            v_nama_alat,
                            ' tidak mencukupi'
                        );

                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = v_pesan;

                    END IF;


                    /*
                    |--------------------------------------------------------------------------
                    | 8. KURANGI STOK TERSEDIA
                    |--------------------------------------------------------------------------
                    */

                    UPDATE alat
                    SET stok_tersedia = stok_tersedia - v_jumlah
                    WHERE id = v_alat_id;


                END LOOP;


                /*
                |--------------------------------------------------------------------------
                | 9. TUTUP CURSOR
                |--------------------------------------------------------------------------
                */

                CLOSE kursor_detail;


                /*
                |--------------------------------------------------------------------------
                | 10. UBAH STATUS PEMINJAMAN
                |--------------------------------------------------------------------------
                |
                | Diajukan → Dipinjam
                |
                */

                UPDATE peminjaman
                SET
                    status = 'dipinjam',
                    petugas_id = p_petugas_id
                WHERE id = p_peminjaman_id;


            END
        ");
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared(
            'DROP PROCEDURE IF EXISTS sp_setujui_peminjaman'
        );
    }
};
