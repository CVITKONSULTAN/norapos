<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetribusiInputMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "[".$this->pengajuan->tipe."] Retribusi Baru Telah Diinput ".$this->pengajuan->no_permohonan;
        return $this->subject($subject)
            ->view('emails.retribusi_input');
    }
}
