<?php

namespace App\Services;

class PhoneNumberService
{
    private $countries;

    public function __construct()
    {
        $this->countries = config('phone.countries');
    }

    public function parsePhone(string $phone): array
    {
        preg_match('/\((\d+)\)/', $phone, $matches);
        $countryCode = $matches[1] ?? null;

        if (! $countryCode || ! isset($this->countries[$countryCode])) {
            return $this->formatResult('Unknown', false, $countryCode, $phone);
        }

        $country = $this->countries[$countryCode];
        $isValid = preg_match($country['pattern'], $phone) === 1;

        return $this->formatResult(
            $country['name'],
            $isValid,
            $countryCode,
            $phone
        );
    }

    public function parsePhones($phones)
    {
        return collect($phones)->map(function ($item) {
            $phone = is_array($item) ? $item['phone'] : $item->phone;
            return $this->parsePhone($phone);
        });
    }

    private function formatResult($country, $isValid, $countryCode, $phone){
        return [
            'country' => $country,
            'state' => $isValid ? 'Valid' : 'Not Valid',
            'country_code' => $countryCode,
            'phone' => $phone,
        ];
    }
}
