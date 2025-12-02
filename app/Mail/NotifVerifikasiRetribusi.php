<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifVerifikasiRetribusi extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;
    public $tracking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pengajuan, $tracking)
    {
        $this->pengajuan = $pengajuan;
        $this->tracking = $tracking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "[".$this->pengajuan->tipe."] Hitung Retribusi ".$this->pengajuan->no_permohonan;
        return $this->subject($subject)
            ->view('emails.notif_retribusi');
    }
}
