<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DokumenTerbitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    public function __construct($pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function build()
    {
        return $this->subject('[TERBIT DOKUMEN] Pengajuan #' . $this->pengajuan->no_permohonan)
                    ->markdown('emails.dokumen_terbit');
    }
}