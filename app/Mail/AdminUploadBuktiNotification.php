<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Sekolah\PPDBSekolah;

class AdminUploadBuktiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(PPDBSekolah $ppdb)
    {
        $this->data = $ppdb;
    }

    public function build()
    {
        $kode = $this->data->kode_bayar ?? 'PPDB';
        $nama = $this->data->nama ?? '-';
        return $this->subject("🆕 BUKTI {$kode} : {$nama} ")
                    ->view('emails.admin_upload_bukti');
    }
}
