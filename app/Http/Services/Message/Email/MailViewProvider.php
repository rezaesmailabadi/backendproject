<?php

namespace App\Http\Services\Message\Email;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailViewProvider extends Mailable
{
    // میل ابل خود سرویس ساختن ایمیل لاراول میباشد 


    // وظیقه ی ساختن اون صفحه ی ایمیل مروبطه 
    use Queueable, SerializesModels;
    // اولی برای استفاده از صف ها 
    // دومی برای استفاده از مدل هاست که باید این دوتا تریت رو حتما ذخیره کنیم 

    public $details;

    public function __construct($details, $subject, $from)
    {
        $this->details = $details;
        $this->subject = $subject;
        $this->from = $from;
    }


    public function build()
    {
        //مهم ترین فانکشن برای ساخت ایمیل  ما 
        return $this->subject($this->subject)->view('emails.send-otp');
        // سابجکت یک متد میل ابل میباشد 
        // بیا و این ویو را برای من ارسال کن 
    }
}
