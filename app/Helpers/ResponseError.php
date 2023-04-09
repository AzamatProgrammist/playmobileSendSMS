<?php

namespace App\Helpers;

class ResponseError
{
    public const NO_ERROR = 'NO_ERROR'; // 'OK'
    public const ERROR_100 = 'ERROR_100'; // 'User is not logged in.'
    public const ERROR_101 = 'ERROR_101'; // 'User does not have the right roles.'
    public const ERROR_102 = 'ERROR_102'; // 'Login or password is incorrect.'
    public const ERROR_103 = 'ERROR_103'; // 'User email address is not verified'
    public const ERROR_104 = 'ERROR_104'; // 'User phone number is not verified'
    public const ERROR_105 = 'ERROR_105'; // 'User account is not verified'
    public const ERROR_106 = 'ERROR_106'; // 'User already exists'
    public const ERROR_107 = 'ERROR_107'; // 'Please login using facebook or google'
    public const ERROR_108 = 'ERROR_108'; // 'User doesn't have Wallet'
    public const ERROR_109 = 'ERROR_109'; // 'Insufficient wallet balance'
    public const ERROR_110 = 'ERROR_110'; // 'Can't update this user role'
    public const ERROR_111 = 'ERROR_111'; // 'Can't add children category to this category'

    public const ERROR_201 = 'ERROR_201'; // 'Wrong OTP Code'
    public const ERROR_202 = 'ERROR_202'; // 'Too many request, try later'
    public const ERROR_203 = 'ERROR_203'; // 'OTP code is expired'

    public const ERROR_204 = 'ERROR_204'; // 'You are not seller yet or your shop is not approved'
    public const ERROR_205 = 'ERROR_205'; // 'Shop already created'
    public const ERROR_206 = 'ERROR_206'; // 'User already has Shop'
    public const ERROR_207 = 'ERROR_207'; // 'Can't update Shop Seller'
    public const ERROR_208 = 'ERROR_208'; // 'Subscription already active'

    public const ERROR_249 = 'ERROR_249'; // 'Invalid coupon'
    public const ERROR_250 = 'ERROR_250'; // 'Coupon expired'
    public const ERROR_251 = 'ERROR_251'; // 'Coupon already used'
    public const ERROR_252 = 'ERROR_252'; // 'Status already used'
    public const ERROR_253 = 'ERROR_253'; // 'Wrong status type'
    public const ERROR_254 = 'ERROR_254'; // 'Can't update Cancel status'

    public const ERROR_400 = 'ERROR_400'; // 'Bad request'
    public const ERROR_403 = 'ERROR_403'; // 'Your project is not activated'
    public const ERROR_404 = 'ERROR_404'; // 'Item\'s not found.'
    public const ERROR_413 = 'ERROR_413'; // 'Undefined Type'
    public const ERROR_415 = 'ERROR_415'; // 'No connection to database'
    public const ERROR_429 = 'ERROR_429'; // 'Too many requests'

    public const ERROR_501 = 'ERROR_501'; // 'Error during created.'
    public const ERROR_502 = 'ERROR_502'; // 'Error during updated.'
    public const ERROR_503 = 'ERROR_503'; // 'Error during deleting.'
    public const ERROR_504 = 'ERROR_504'; // 'Can't delete record that has children.'
    public const ERROR_505 = 'ERROR_505'; // 'Can't delete default record.'
    public const ERROR_506 = 'ERROR_506'; // 'Already exists.'
    public const ERROR_507 = 'ERROR_507'; // 'Can't delete record that has products.'
    public const ERROR_508 = 'ERROR_508'; // 'Excel format incorrect or data invalid.'


}
