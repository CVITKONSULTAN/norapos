<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePerubRetribusiPrasaranasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perub_retribusi_prasaranas', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('jenis_prasarana')->nullable();
            $table->string('bangunan')->nullable();
            $table->string('satuan')->nullable();

            $table->decimal('harga_satuan', 15, 3)->nullable();
            $table->decimal('pembangunan_baru', 15, 3)->nullable();
            $table->decimal('rusak_berat', 15, 3)->nullable();
            $table->decimal('rusak_sedang', 15, 3)->nullable();

            $table->timestamps();
            $table->datetime('deleted_at')->nullable();
        });

        // === SEED CSV OTOMATIS ===
        $path = database_path('seeders/data/data_seed_perub_ciptakarya.csv');

        if (file_exists($path)) {

            $file = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Hapus BOM pada header
            $file[0] = preg_replace('/^\xEF\xBB\xBF/', '', $file[0]);

            $header = str_getcsv($file[0], ';'); // CSV pakai semicolon
            $header = array_map('trim', $header);

            // Loop baris data
            for ($i = 1; $i < count($file); $i++) {

                $row = str_getcsv($file[$i], ';');
                $row = array_map('trim', $row);

                // Skip kalau jumlah kolomnya tidak pas
                if (count($row) !== count($header)) {
                    continue;
                }

                $data = array_combine($header, $row);

                DB::table('perub_retribusi_prasaranas')->insert([
                    'jenis_prasarana'   => $data['jenis_prasarana'] ?? null,
                    'bangunan'          => $data['bangunan'] ?? null,
                    'satuan'            => $data['satuan'] ?? null,
                    'harga_satuan'      => is_numeric($data['harga_satuan']) ? $data['harga_satuan'] : null,
                    'pembangunan_baru'  => is_numeric($data['pembangunan_baru']) ? $data['pembangunan_baru'] : null,
                    'rusak_berat'       => is_numeric($data['rusak_berat']) ? $data['rusak_berat'] : null,
                    'rusak_sedang'      => is_numeric($data['rusak_sedang']) ? $data['rusak_sedang'] : null,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perub_retribusi_prasaranas');
    }
}
