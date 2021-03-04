<?php

namespace App\Rules;

use League\ISO3166\Exception\DomainException;
use League\ISO3166\ISO3166;
use Illuminate\Contracts\Validation\Rule;

class Country implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(ISO3166 $iso3166)
    {
        $this->iso3166 = $iso3166;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $this->iso3166->alpha2($value);

            return true;
        } catch (DomainException $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid country selected.';
    }
}
