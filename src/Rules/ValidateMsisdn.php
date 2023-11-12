<?php

namespace Aguva\Ussd\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\PhoneNumberUtil;

class ValidateMsisdn implements ValidationRule
{
    public $unique_check;
    public $safaricom_check;
    public $model;
    public $column;
    public $source_param;


    public function __construct($unique_check = true, $safaricom_check = false, $model = 'User', $column = 'msisdn', $source_param = 'msisdn')
    {
        $this->unique_check = $unique_check;
        $this->safaricom_check = $safaricom_check;
        $this->model = 'App\\Models\\'.$model;
        $this->column = $column;
        $this->source_param = $source_param;
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

        if ($this->unique_check){
            $count = $this->model::where($this->column, $validation['msisdn'])->first();
            if ($count) {
                $fail('Msisdn '.$validation['msisdn']. ' already taken');
            }
        }
        if ($this->safaricom_check){
            $carrierMapper = PhoneNumberToCarrierMapper::getInstance();
            $chNumber = PhoneNumberUtil::getInstance()->parse($validation['msisdn'], "KE");
            $msisdn_network = $carrierMapper->getNameForNumber($chNumber, 'en');
            if (strtolower($msisdn_network) != 'safaricom') {
                $fail('Msisdn '.$validation['msisdn']. ' is not a safaricom number');
            }
        }
        request()->merge([$this->source_param => $validation['msisdn']]);
    }
}
