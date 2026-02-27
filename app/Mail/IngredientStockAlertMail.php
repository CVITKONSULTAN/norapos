<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IngredientStockAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alertIngredients;
    public $transaction;
    public $admin;

    public function __construct($alertIngredients, $transaction, $admin)
    {
        $this->alertIngredients = $alertIngredients;
        $this->transaction = $transaction;
        $this->admin = $admin;
    }

    public function build()
    {
        return $this->subject('⚠️ Peringatan Stok Bahan Minus - ' . $this->transaction->invoice_no)
                    ->view('emails.ingredient_stock_alert');
    }
}
