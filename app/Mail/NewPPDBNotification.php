<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Sekolah\PPDBSekolah;

class NewPPDBNotification extends Mailable
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
        return $this->subject("Pendaftaran PPDB Baru — {$kode}")
                    ->view('emails.new_ppdb')
                    ->with(['ppdb' => $this->ppdb]);
    }
}
