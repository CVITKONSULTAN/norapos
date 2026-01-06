<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PengajuanBaruSimbgMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuanList;
    public $recipient;
    public $count;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pengajuanList, $recipient)
    {
        $this->pengajuanList = $pengajuanList;
        $this->recipient = $recipient;
        $this->count = $pengajuanList->count();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "[SIMBG SYNC] {$this->count} Pengajuan Baru dari SIMBG";
        
        return $this->subject($subject)
            ->view('emails.pengajuan_baru_simbg');
    }
}
