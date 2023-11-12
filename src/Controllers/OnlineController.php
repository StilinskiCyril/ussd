<?php

namespace Aguva\Ussd\Controllers;

use Aguva\Ussd\Repositories\ActivityLibrary;
use Illuminate\Http\Request;
use Aguva\Ussd\Rules\ValidateMsisdn;

class OnlineController extends Controller
{
    // validate and process payload from provider
    function processPayload(Request $request){
        $this->validate($request, [
            'msisdn' => ['required', new ValidateMsisdn(false)],
            'text' => ['nullable'],
            'sessionId' => ['required']
        ]);

        // Log the request
        if (config('ussd.restrict_to_whitelist')){
            app('log')->info(json_encode($request->all()));
        }

        $input = $this->cleanUssd($request->input('text',''));
        $originalUssdString = '*'.config('ussd.ussd_code').'*'.$request->input('text').'#';
        $msisdn = $request->input('phoneNumber');
        $sessionId = $request->input('sessionId');

        if (strpos($msisdn, '+') !== false){
            $new_msisdn = explode('+', $msisdn)[1];
        } else {
            $new_msisdn = $msisdn;
        }

        // whitelist msisdns that can access the ussd
        if (config('ussd.restrict_to_whitelist') && !in_array($new_msisdn, explode(',', config('ussd.whitelist_msisdns')))){
            return "END STILINSKI-USSD";
        }

        $activityLibrary = new ActivityLibrary($new_msisdn, $sessionId, $input, $originalUssdString, "Handler");
        $response = $activityLibrary->finalResponse();

        //delay session end to give stk time to arrive (in case your app has an m-pesa stk feature).
        if ($response['endSession'] == true) {
            sleep(config('ussd.end_session_sleep_seconds'));
        }

        return $response['endSession'] ? "END " . $response['response'] : "CON " . $response['response'];
    }

    private function cleanUssd($ussdString)
    {
        if (!$ussdString) {
            return '';
        }
        return collect(explode("*", $ussdString))->last();
    }
}