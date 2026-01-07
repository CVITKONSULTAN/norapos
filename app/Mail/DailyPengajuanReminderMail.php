<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailyPengajuanReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuanList;
    public $userName;
    public $userRole;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pengajuanList, $userName, $userRole)
    {
        $this->pengajuanList = $pengajuanList;
        $this->userName = $userName;
        $this->userRole = $userRole;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $jumlah = count($this->pengajuanList);
        $subject = "Pengingat: {$jumlah} Pengajuan Menunggu Tindakan Anda";
        
        return $this->subject($subject)
            ->view('emails.daily_pengajuan_reminder');
    }
}
