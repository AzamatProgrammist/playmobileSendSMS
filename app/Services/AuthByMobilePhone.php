<?php

namespace App\Services;

use App\Helpers\ResponseError;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Services\SMSBaseService;
use App\Services\UserWalletService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class AuthByMobilePhone
{
    use ApiResponse;
    public $smsBaseService;
    public function __construct(SMSBaseService $smsBaseService)
    {
        $this->smsBaseService = $smsBaseService;
    }

    /**
     * @return mixed
     */
    protected function getModelClass()
    {
        return User::class;
    }

    /**
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function authentication(array $array)
    {
        $phone = preg_replace('/[^\d]/', '', $array['phone']);
        $sms = $this->smsBaseService->smsGateway($phone);

        if ($sms['status']) {
            return $this->successResponse(trans('web.otp_successfully_send', [], request()->lang ?? 'en'), [
                'verifyId' => $sms['verifyId'],
                'phone' => $sms['phone'],
            ]);
        } else {
            return $this->errorResponse(
                ResponseError::ERROR_400, $sms['message'],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

//    public function resetPassword(array $array)
//    {
//        $user = User::firstWhere('phone', $array['phone']);
//        if (!$user)
//        {
//            return $this->errorResponse(ResponseError::ERROR_404, 'errors.' .ResponseError::ERROR_404, Response::HTTP_NOT_FOUND);
//        }
//        $phone = preg_replace('/[^\d]/', '', $array['phone']);
//
//        $verifyId = Str::uuid();
//
//        $OPTCode = rand(100000, 999999);
//
//        $message = $this->message.$OPTCode;
//
//        $result = (new PlayMobileService())->sendCustomSms($phone,$message,
//            [
//                'verifyId' => $verifyId,
//            ]
//        );
//        if (!$result['status']) {
//            return $this->errorResponse($result['code'], $result['message']);
//        }
//        Cache::put('sms-'. $verifyId, [
//            'phone' => $phone,
//            'verifyId' => $verifyId,
//            'OTPCode' => $OPTCode,
//            'expiredAt' => now()->addMinutes(5),
//        ], 1800);
//
//        Cache::put($verifyId, 3, 300);
//
//
//        return $this->successResponse('OTP successfully send', [
//            'verifyId' => $verifyId,
//            'phone' => Str::mask($phone, '*', -12, 8),
//        ]);
//    }

    public function confirmOPTCode(array $array)
    {
        $data = Cache::get('sms-' . $array['verifyId']);

        if ($data){
            $count = $this->setOTPCount($data);

            if ($count == 0){
                return $this->errorResponse(ResponseError::ERROR_202, trans('errors.'. ResponseError::ERROR_202, [], request()->lang ?? 'en'), Response::HTTP_TOO_MANY_REQUESTS);
            }

            if (Carbon::parse($data['expiredAt']) < now()){
                return $this->errorResponse(ResponseError::ERROR_203, trans('errors.'. ResponseError::ERROR_203, [], request()->lang ?? 'en'), Response::HTTP_BAD_REQUEST);
            }

            if ($data['OTPCode'] == $array['verifyCode'])
            {
                $user = User::where('phone', $data['phone'])->first();
                if (!$user) {
                    $user = User::create([
                        'firstname' => 'No name',
                        'phone' => $data['phone'],
                        'active' => 1,
                        'phone_verified_at' => now(),
                    ]);
                } else {
                    $user->update([
                        'active' => 1,
                        'phone_verified_at' => now(),
                    ]);
                }

                if(!isset($user->wallet)){
                    (new UserWalletService())->create($user);
                }

                \Log::debug('u', [$user]);
                $token = $user->createToken('api_token')->plainTextToken;

                Cache::forget('sms-' . $array['verifyId']);
                return $this->successResponse('User successfully login', [
                    'token' => $token,
                    'user' => UserResource::make($user),
                ]);
            } else {
                return $this->errorResponse(ResponseError::ERROR_201, trans('errors.'. ResponseError::ERROR_201, [], request()->lang ?? 'en'), Response::HTTP_BAD_REQUEST);
            }
        }
        return $this->errorResponse(ResponseError::ERROR_404, trans('errors.'. ResponseError::ERROR_404, [], request()->lang ?? 'en'), Response::HTTP_NOT_FOUND);
    }

    public function setOTPCount(array $array)
    {
        $count = Cache::get($array['verifyId']);
        if ($count > 0) {
            Cache::forget($array['verifyId']);
            Cache::put($array['verifyId'], $count - 1, 300);
        }
        return $count;
    }

}
