<?php

namespace Aguva\Ussd\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\PhoneNumberUtil;

class ValidateMsisdn implements ValidationRule
{
    public $uniqueCheck;
    public $safaricomCheck;
    public $model;
    public $column;
    public $sourceParam;


    public function __construct($uniqueCheck = true, $safaricomCheck = false, $model = 'User', $column = 'msisdn', $sourceParam = 'msisdn')
    {
        $this->uniqueCheck = $uniqueCheck;
        $this->safaricomCheck = $safaricomCheck;
        $this->model = 'App\\Models\\'.$model;
        $this->column = $column;
        $this->sourceParam = $sourceParam;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $validation = validateMsisdn($value);

        if (!$validation['isValid']) {
            $fail($validation['msisdn']. ' is invalid');
        }

        if ($this->uniqueCheck){
            $count = $this->model::where($this->column, $validation['msisdn'])->first();
            if ($count) {
                $fail('Msisdn/ phone number '.$validation['msisdn']. ' already taken');
            }
        }
        if ($this->safaricomCheck){
            $carrierMapper = PhoneNumberToCarrierMapper::getInstance();
            $chNumber = PhoneNumberUtil::getInstance()->parse($validation['msisdn'], "KE");
            $msisdn_network = $carrierMapper->getNameForNumber($chNumber, 'en');
            if (strtolower($msisdn_network) != 'safaricom') {
                $fail('Msisdn/ phone number '.$validation['msisdn']. ' is not a safaricom phone number');
            }
        }
        request()->merge([$this->sourceParam => $validation['msisdn']]);
    }
}
