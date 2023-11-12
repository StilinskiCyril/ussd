<?php

namespace Aguva\Ussd\Controllers;

use Aguva\Ussd\Repositories\ActivityLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Aguva\Ussd\Rules\ValidateMsisdn;

class TestController extends Controller
{
    public function simulatorPage()
    {
        return view('ussd-views::simulator', ['input' => ['session_id' => Str::uuid()]]);
    }

    public function processPayload(Request $request)
    {
        $request->validate([
            'msisdn' => ['required', new ValidateMsisdn(false)],
            'input' => ['nullable'],
            'session_id' => ['required']
        ]);

        $input = $request->input('input');
        $originalUssdString = $input;
        $msisdn = $request->input('msisdn');
        $sessionId = $request->input('session_id');

        if (strpos($msisdn, '+') !== false){
            $new_msisdn = explode('+', $msisdn)[1];
        } else {
            $new_msisdn = $msisdn;
        }

        //whitelist msisdns
        if (config('ussd.restrict_to_whitelist') && !in_array($new_msisdn, explode(',', config('ussd.whitelist_msisdns')))){
            return "END STILINSKI-USSD";
        }

        $activityLibrary = new ActivityLibrary($new_msisdn, $sessionId,$input, $originalUssdString, "UssdHandler");
        $response = $activityLibrary->finalResponse();
        $text = $response['response'];
        $input = request()->except('_token');

        return view('ussd-views::simulator', compact('text', 'input'));
    }

    private function cleanUssd($ussdString)
    {
        if (!$ussdString) {
            return '';
        }
        return collect(explode("*", $ussdString))->last();
    }
}