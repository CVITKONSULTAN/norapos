<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PetugasAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;
    public $petugas;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pengajuan, $petugas)
    {
        $this->pengajuan = $pengajuan;
        $this->petugas = $petugas;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "[".$this->pengajuan->tipe."] Penugasan Pemeriksaan Baru ".$this->pengajuan->no_permohonan;
        return $this->subject($subject)
            ->view('emails.petugas_assigned');
    }
}
