<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    public function sendsms()
    {
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $sendernumber = getenv("TWILIO_PHONE");
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create("+63 949 015 8973", // to
                    [
                        "body" => "Test ni",
                        "from" =>  $sendernumber
                    ]
            );

            dd("message sent successfully");


    }

}
