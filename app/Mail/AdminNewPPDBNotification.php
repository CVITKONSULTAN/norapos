<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Sekolah\PPDBSekolah;

class AdminNewPPDBNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ppdb;

    public function __construct(PPDBSekolah $ppdb)
    {
        $this->ppdb = $ppdb;
    }

    public function build()
    {
        $kode = $this->ppdb->kode_bayar ?? 'PPDB';
        $nama = $this->ppdb->nama ?? '-';
        return $this->subject("🆕 {$kode} : {$nama} ")
                    ->view('emails.admin_new_ppdb')
                    ->with(['ppdb' => $this->ppdb]);
    }
}
