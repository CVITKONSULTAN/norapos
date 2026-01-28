<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MagicLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $petugas;
    public $loginUrl;

    /**
     * Create a new message instance.
     *
     * @param $petugas
     * @param $loginUrl
     */
    public function __construct($petugas, $loginUrl)
    {
        $this->petugas = $petugas;
        $this->loginUrl = $loginUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Link Login Petugas Lapangan - DPMPTSP Kubu Raya')
                    ->view('emails.magic_link');
    }
}
