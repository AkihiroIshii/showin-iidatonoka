<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\ValidationException;

class EqualSumOfTimeRule implements ValidationRule
{
    // protected int $sum_abs;
    // protected int $sum_alt;

    // public function __construct(int $sum_abs, int $sum_alt)
    // {
    //     $this->sum_abs = $sum_abs;
    //     $this->sum_alt = $sum_alt;
    // }

    // public function passes($attribute, $value)
    // {
    //     // バリデーションロジック
    //     return $value == $this->sum_abs;
    // }

    // public function message()
    // {
    //     return 'The sum values do not match.';
    // }

    // public function validate(string $attribute, mixed $value, Closure $fail): void
    // {
    //     if ($value !== $this->sum_alt) {
    //         $fail('The sum values do not match.');
    //     }
    // }


    // /**
    //  * Run the validation rule.
    //  *
    //  * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
    //  */
    // protected string $sum_check;

    // public function __construct(string $sum_check) {
    //     $this->sum_check = $sum_check;
    // }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // if (isset($this->sum_check)) {
        //     $fail($this->sum_check);
        // }
        // return;

        // dd($value);
        if (isset($value)) {
            // dd($value);
            throw ValidationException::withMessages([$attribute => strval($value)]);
        }

        // sum_checkがセットされていれば、エラーを発生させる
        // if (isset($this->sum_check) && $value != $this->sum_check) {
        //     // エラーメッセージを$fail関数で返す
        //     $fail('The sum values do not match.');
        // }
    }
}
