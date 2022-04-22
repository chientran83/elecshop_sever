<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendCodeToEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    public function product(){
        return $this->belongsToMany(product::class,'tbl_order_product','order_id','product_id');
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->details;
        return $this->subject($data['title'])
        ->view('sendEmail.sendCodeGetPassword',compact('data'));
    }
}
