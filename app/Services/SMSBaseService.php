<?php

namespace App\Services;

use App\Models\SmsGateway;
use App\Services\SMSXabarService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SMSBaseService
{
    public $smsXabarService;

    public function __construct(SMSXabarService $smsXabarService)
    {
        $this->smsXabarService = $smsXabarService;
    }

    /**
     * @return mixed
     */
    protected function getModelClass()
    {
        return SmsGateway::class;
    }

    /**
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function smsGateway($phone)
    {
        $gateway = SmsGateway::where('active', 1)->first();
        $otp = $this->setOTP();

        switch ($gateway->type){
            
            case "smsxabar":
                $result = $this->smsXabarService->sendSms($gateway, $phone, $otp);
                if ($result['status']){
                    $this->setOTPToCache($phone, $otp);
                    return ['status' => true, 'verifyId' => $otp['verifyId'], 'phone' => Str::mask($phone, '*', -12, 8)];
                }
                return ['status' => false, 'message' => $result['message']];
        }
    }


    public function setOTP(){
        return ['verifyId' => Str::uuid(), 'otpCode' => rand(100000, 999999)];
    }

    public function setOTPToCache($phone, $otp){
        Cache::put('sms-'. $otp['verifyId'], [
            'phone' => $phone,
            'verifyId' => $otp['verifyId'],
            'OTPCode' => $otp['otpCode'],
            'expiredAt' => now()->addMinutes(5),
        ], 1800);

        Cache::put($otp['verifyId'], 3, 300);
    }
}
