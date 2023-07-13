<?php







// سرویس ملی پیامک

// وب سرویس ای پی آی درون پنل پیامکی ما باید از ای پی آی های آن استفاده کنیم نمونه کد برای زبان مورد نظر هس

// اگر بزنیم روش یه فایل برای ما دانلود میشه که چندین تا فایل درون آن دارد که در آن پی اج پی خام میباشد 

// بعد ما این هارو به صورت یک سرویس درمیاریم 

// بعد به ازای تک تک فایل هایی که دانلود کردیم یک پابلیک فانکشن ایجاد میکنیم و محتویات آن هارا درون آن قرار میدهیم 

// نکته : برای اینکه یه سری سرویس مثلا تعریف کردی و خطا داد پشت اسم هاش میتونی بک اسلش پشت اسمش بزاری تا برات خطا نگیره 



namespace App\Http\Services\Message\SMS;

use Illuminate\Support\Facades\Config;


class MeliPayamakService
{

    private $username;
    private $password; // sms را به کمک این دو تا متغیر ارسال میکنیم  
    // موارد بالا را از فایل کانفیک میخونیم به طور دستی رفتیم و در کانفیگ یه فایل درست کردیم به نام اس ام اس دات پی اچ پی
    // تنظیمات  مربوط به اس ام اس من در اون فایل قرار دارد 


    public function __construct()
    {
        $this->username = Config::get('sms.username'); // اولی اسم فایله و دومی اسم اون پراپرتی درون آن میباشد 
        $this->password = Config::get('sms.password'); //موارد را از فایل کانفیگ در بخش کانفیگ ها خوندیم 
    }






    public function addContact()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/contacts.asmx?wsdl', array('encoding' => 'UTF-8'));
        $parameters['username'] = "***";
        $parameters['password'] = "***";
        $parameters['groupIds'] = "***"; //My group Id in panel
        $parameters['firstname'] = "MyUserFirstName";
        $parameters['lastname'] = "MyUserLastName";
        $parameters['nickname'] = "MyUserNickName";
        $parameters['corporation'] = "MyUserCorporation";
        $parameters['mobilenumber'] = "MyUserMobileNumber";
        $parameters['phone'] = "MyUserPhone";
        $parameters['fax'] = "MyUserFax";
        $parameters['birthdate'] = 2013 - 06 - 15; //for Example
        $parameters['email'] = "MyUserEmailAddress";
        $parameters['gender'] = 2; //For Example
        $parameters['province'] = 18; //For Example
        $parameters['city'] = 711; //For Example
        $parameters['address'] = "MyUserAddress";
        $parameters['postalCode'] = "MyUserPostalCode";
        $parameters['additionaldate'] = 2013 - 06 - 15; //For Example
        $parameters['additionaltext'] = "MyUserAdditionalText";
        $parameters['descriptions'] = "MyUserDescriptions";
        echo $sms_client->AddContact($parameters)->AddContactResult;
    }



    public function addSchedule()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/schedule.asmx?wsdl', array('encoding' => 'UTF-8'));

        $parameters['username'] = "***";
        $parameters['password'] = "***";
        $parameters['to'] =  "912***";
        $parameters['from'] = "3000***";
        $parameters['text'] = "Test";
        $parameters['isflash'] = false;
        $parameters['scheduleDateTime'] = "2013-06-15T16:50:45";
        $parameters['period'] = "Once";
        echo $sms_client->AddSchedule($parameters)->AddScheduleResult;
    }


    public function getCredit()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/Send.asmx?wsdl', array('encoding' => 'UTF-8'));

        $parameters['username'] = "username";
        $parameters['password'] = "password";

        echo $sms_client->GetCredit($parameters)->GetCreditResult;
    }


    public function getInboxCountSoapClient()
    {


        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/receive.asmx?wsdl', array('encoding' => 'UTF-8'));

        $parameters['username'] = "username";
        $parameters['password'] = "pass";
        $parameters['isRead'] = false;

        echo $sms_client->GetInboxCount($parameters)->GetInboxCountResult;
    }



    public function getMessageStr()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/Receive.asmx?wsdl', array('encoding' => 'UTF-8'));
        $parameters['username'] = "username";
        $parameters['password'] = "password";
        $parameters['location'] =  1;
        $parameters['from'] = "";
        $parameters['index'] = 0;
        $parameters['count'] = 10;
        echo $sms_client->GetMessageStr($parameters)->GetMessageStrResult;
    }

    public function SendSimpleSms2SoapClient()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/send.asmx?wsdl', array('encoding' => 'UTF-8'));

        $parameters['username'] = "demo";
        $parameters['password'] = "demo";
        $parameters['to'] = "912...";
        $parameters['from'] = "1000..";
        $parameters['text'] = "تست";
        $parameters['isflash'] = false;

        echo $sms_client->SendSimpleSMS2($parameters)->SendSimpleSMS2Result;
    }

    // public function sendSmsNuSoap()
    // {
    //     require_once('nusoap.php');
    //     $client = new nusoap_client('http://api.payamak-panel.com/post/send.asmx?wsdl');

    //     $err = $client->getError();

    //     if ($err) {

    //         echo 'Constructor error' . $err;
    //     }

    //     $parameters['username'] = "demo";
    //     $parameters['password'] = "demo";
    //     $parameters['to'] = "912...";
    //     $parameters['from'] = "1000..";
    //     $parameters['text'] = "تست";
    //     $parameters['isflash'] = false;


    //     $result = $client->call('SendSimpleSMS2', $parameters);
    //     print_r($result);
    // }





    public function sendSmsSoapClient($from, array $to, $text, $isFlash = true)
    {

        // ما داریم از روش سوپ کلاینت استفاده میکنیم و این باید روی سیستم ما نصب باشه 
        // اگر در لوکال بود که به صورت دستی باید بریم در زمپ و این رو فعال کنیم 
        // اگر در لوکال نبود باید به کسی که سرور را راه اندازی میکنه بهش بگیم 

        // موارد را در داخل فانکشن اونایی که قراره مقدار دهی بشه فراخوانی کردیم 

        // ما بیشتر با این متد کار داریم و با متد های دیگر زیادی کار نداریم 

        // turn off the WSDL cache
        ini_set("soap.wsdl_cache_enabled", "0");
        try {
            $client = new \SoapClient('http://api.payamak-panel.com/post/send.asmx?wsdl', array('encoding' => 'UTF-8'));
            $parameters['username'] = $this->username;
            $parameters['password'] = $this->password;
            $parameters['from'] = $from;
            $parameters['to'] = $to;
            $parameters['text'] = $text;
            $parameters['isflash'] = $isFlash;
            $parameters['udh'] = "";
            $parameters['recId'] = array(0);
            $parameters['status'] = 0x0;



            
            $GetCreditResult = $client->GetCredit(array("username" => $this->username, "password" => $this->password))->GetCreditResult;
            // نتیجه ی اعتبار 
            $sendSmsResult = $client->SendSms($parameters)->SendSmsResult;
            // نتیجه ی ارسال اس ام اس 
            if ($GetCreditResult == 0 && $sendSmsResult == 1) {
                // در داکیونتیشن خود ملی پیامک نوشته گفته اگر این دوتا عدد 0 و 1 شده بود ینی کار درست انجام شده است 
                return true;
            } else {
                return false;
            }
        } catch (\SoapFault $ex) {
            echo $ex->faultstring;
        }
    }




}
