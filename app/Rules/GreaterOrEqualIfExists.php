<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Str;
use Illuminate\Translation\PotentiallyTranslatedString;

class GreaterOrEqualIfExists implements DataAwareRule, InvokableRule
{
    public function __construct(private readonly string $fieldName)
    {
    }

    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail): void
    {
        if ($this->data[$this->fieldName] && $this->data[$this->fieldName] > $value) {
            $fail(
                sprintf(
                'The %s must be greater than %s.',
                Str::headline($attribute),
                Str::headline($this->fieldName)
            )
            );
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data): static
    {
        $this->data = $data;

        return $this;
    }
}
