<?php

use Aguva\Ussd\Models\UssdUser;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

// validate msisdn
function validateMsisdn($phone): array
{
    $phoneUtil = PhoneNumberUtil::getInstance();
    try {
        $kenyaNumberProto = $phoneUtil->parse($phone, "KE");
        $isValid = $phoneUtil->isValidNumber($kenyaNumberProto);
        if ($isValid) {
            $phone = $phoneUtil->format($kenyaNumberProto, PhoneNumberFormat::E164);
            return [
                'isValid' => $isValid,
                'msisdn' => substr($phone, 1)
            ];
        }
        return [
            'isValid' => $isValid,
            'msisdn' => $phone
        ];
    } catch (NumberParseException $e) {
        Log::info($e->getMessage());
        return [
            'isValid' => false,
            'msisdn' => $phone
        ];
    }
}

// generate random integer
if (!function_exists('generateRandomInt')){
    function generateRandomInt($digits = 6): string
    {
        $i = 0;
        $pin = "";
        while($i < $digits){
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }
}

// load super admin account
if (!function_exists('loadSuperAdminAccount')) {
    function loadSuperAdminAccount($value, $column = 'email')
    {
        return User::where($column, $value)->first();
    }
}

// save new user instance
if (!function_exists('saveUser')){
    function saveUser($userData){
        UssdUser::create([
            'msisdn' => $userData['msisdn'],
            'locale' => 'en'
        ]);
    }
}
