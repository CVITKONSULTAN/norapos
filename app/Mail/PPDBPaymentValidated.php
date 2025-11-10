<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Sekolah\PPDBSekolah;

class PPDBPaymentValidated extends Mailable
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
        return $this->subject("Pembayaran PPDB Kamu Telah Divalidasi — {$kode}")
                    ->view('emails.ppdb_payment_validated')
                    ->with(['ppdb' => $this->ppdb]);
    }
}
