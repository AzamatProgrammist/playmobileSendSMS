<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseError;
use App\Services\AuthByMobilePhone;
use App\Http\Controllers\Controller;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public $authByMobilePhone;

    public function __construct(AuthByMobilePhone $authByMobilePhone)
    {
        $this->authByMobilePhone = $authByMobilePhone;
    }
    public function register(Request $request)
    {
       if (isset($request->phone)){
            $user = User::where('phone', $request->phone)->first();
            if ($user) {
                return $this->errorResponse(
                    ResponseError::ERROR_106, trans('errors.' . ResponseError::ERROR_106, [], request()->lang ?? config('app.locale')),
                    Response::HTTP_BAD_REQUEST
                );
            }
            return $this->authByMobilePhone->authentication($request->all());
        } elseif (isset($request->email)) {
            return (new AuthByEmail())->authentication($request->all());
        }
        return $this->errorResponse(ResponseError::ERROR_400, 'errors.'.ResponseError::ERROR_400, Response::HTTP_BAD_REQUEST);
    }
}
