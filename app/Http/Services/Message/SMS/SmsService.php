<?php

namespace App\Http\Services\Message\SMS;

use App\Http\Interfaces\MessageInterface;
use App\Http\Services\Message\SMS\MeliPayamakService;

class SmsService implements MessageInterface
{

    private $from; // از کجا ارسال بشه 
    private $text; //متن پیامک چی باشه ؟ 
    private $to; // به کی قراره ارسال بشه 
    private $isFlash = true;



    public function fire()
    {
        // ارسال پیامک به کمک ملی پیامک باید اینجا ارسال بشه 
        // ینی عملا ارسال اس ام اس باید در این متد انجام بشه 
        $meliPayamak = new MeliPayamakService();
        return $meliPayamak->sendSmsSoapClient($this->from, $this->to, $this->text, $this->isFlash);
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }


    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }


    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function getIsFlash()
    {
        return $this->to;
    }

    public function setIsFlash($flash)
    {
        $this->isFlash = $flash;
    }
}
