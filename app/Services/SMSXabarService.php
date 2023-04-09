<?php

namespace App\Services;

use App\Models\SmsGateway;
use Illuminate\Support\Str;

class SMSXabarService
{
    protected function getModelClass()
    {
        return SmsGateway::class;
    }

    /**
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function sendSms($gateway, $phone, $otp): array
    {
        if (!isset($gateway->api_key) || !isset($gateway->secret_key)) {
            return ['status' => false, 'message' => 'Bad credentials. Contact with Support Team'];
        }

        $input = [
            'messages' => [
                [
                    'recipient' => $phone,
                    'message-id' => '0',
                    'sms' => [
                        'originator' => '3700',
                        'content' => [
                            'text' => Str::replace('#OTP#', $otp['otpCode'], $gateway->text)
                        ]
                    ]
                ]
            ]
        ];

        try {
            $url = "http://91.204.239.44/broker-api/send";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=UTF-8'));
            curl_setopt($ch, CURLOPT_USERPWD, "{$gateway->api_key}:{$gateway->secret_key}");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            curl_close($ch);

            return ['status' => true];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
