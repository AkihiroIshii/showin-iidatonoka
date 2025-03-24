<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use App\Rules\EqualSumOfTimeRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return str_starts_with($this->path(), 'transfer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // 欠席時間と振替希望時間の合計が一致しているか
        //入力値の取得(秒データに変換)
        $f_abs_1 = strtotime($this->input('time_from_absence_1'));
        $f_abs_2 = strtotime($this->input('time_from_absence_2'));
        $f_abs_3 = strtotime($this->input('time_from_absence_3'));
        $t_abs_1 = strtotime($this->input('time_to_absence_1'));
        $t_abs_2 = strtotime($this->input('time_to_absence_2'));
        $t_abs_3 = strtotime($this->input('time_to_absence_3'));
        $f_alt_1 = strtotime($this->input('time_from_alternative_1'));
        $f_alt_2 = strtotime($this->input('time_from_alternative_2'));
        $f_alt_3 = strtotime($this->input('time_from_alternative_3'));
        $t_alt_1 = strtotime($this->input('time_to_alternative_1'));
        $t_alt_2 = strtotime($this->input('time_to_alternative_2'));
        $t_alt_3 = strtotime($this->input('time_to_alternative_3'));

        //終了時刻 - 開始時刻
        $diff_abs_1 = $t_abs_1 - $f_abs_1;
        $diff_abs_2 = $t_abs_2 - $f_abs_2;
        $diff_abs_3 = $t_abs_3 - $f_abs_3;
        $diff_alt_1 = $t_alt_1 - $f_alt_1;
        $diff_alt_2 = $t_alt_2 - $f_alt_2;
        $diff_alt_3 = $t_alt_3 - $f_alt_3;

        //欠席時間と振替時間の合計
        $sum_abs = $diff_abs_1 + $diff_abs_2 + $diff_abs_3;
        $sum_alt = $diff_alt_1 + $diff_alt_2 + $diff_alt_3;

        // 分に変換
        $sum_abs = $sum_abs/60;
        $sum_alt = $sum_alt/60;
        // $sum_abs = Carbon::createFromTimestampUTC($sum_abs)->format('H:i');
        // $sum_alt = Carbon::createFromTimestampUTC($sum_alt)->format('H:i');

        $sum_check = null;
        if ($sum_abs !== $sum_alt) {
            $sum_check = '欠席時間の合計(' . $sum_abs . '分)が、振替時間の合計(' . $sum_alt . '分)と一致していません。';
        }

        // dd($this->input('user_id'));
        $this->merge(['sum_check' => $sum_check]); //初期化
        // dd($this->input('sum_check'));
        return [
            'user_id' => 'required',
            'day_of_absence_1' => 'required',
            'day_of_absence_2' => 'nullable',
            'day_of_absence_3' => 'nullable',
            'time_from_absence_1' => 'required',
            'time_from_absence_2' => 'nullable',
            'time_from_absence_3' => 'nullable',
            'time_to_absence_1' => ['required', 'after:time_from_absence_1'],
            'time_to_absence_2' => ['nullable', 'after:time_from_absence_2'],
            'time_to_absence_3' => ['nullable', 'after:time_from_absence_3'],
            'reason_of_absence_1' => 'required',
            'reason_of_absence_2' => 'nullable',
            'reason_of_absence_3' => 'nullable',
            'alternative_day_1' => 'required',
            'alternative_day_2' => 'nullable',
            'alternative_day_3' => 'nullable',
            'time_from_alternative_1' => 'required',
            'time_from_alternative_2' => 'nullable',
            'time_from_alternative_3' => 'nullable',
            'time_to_alternative_1' => ['required', 'after:time_from_alternative_1'],
            'time_to_alternative_2' => ['nullable', 'after:time_from_alternative_2'],
            'time_to_alternative_3' => ['nullable', 'after:time_from_alternative_3'],
            'status' => 'nullable',
            // 'sum_check' => [new EqualSumOfTimeRule($this->input('sum_check'))],
            'sum_check' => [new EqualSumOfTimeRule()],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->sometimes('sum_check', [new EqualSumOfTimeRule()], function($input) {
            // dd($input->sum_check);
            return true;
        });
        // dd($this->all());
    }

    public function messages(): array
    {
        return [
            'user_id' => '対象の生徒は必ず入力して下さい。',
            'day_of_absence_1' => '欠席日は必ず入力して下さい。',
            'day_of_absence_2' => 'nullable',
            'day_of_absence_3' => 'nullable',
            'time_from_absence_1' => '開始時間は必ず入力して下さい。',
            'time_from_absence_2' => 'nullable',
            'time_from_absence_3' => 'nullable',
            'time_to_absence_1' => '終了時間は開始時間よりも遅い時間を入力して下さい。',
            'time_to_absence_2' => '終了時間は開始時間よりも遅い時間を入力して下さい。',
            'time_to_absence_3' => '終了時間は開始時間よりも遅い時間を入力して下さい。',
            'reason_of_absence_1' => '欠席理由は必ず入力して下さい。',
            'reason_of_absence_2' => 'nullable',
            'reason_of_absence_3' => 'nullable',
            'alternative_day_1' => '振替希望日は必ず入力して下さい。',
            'alternative_day_2' => 'nullable',
            'alternative_day_3' => 'nullable',
            'time_from_alternative_1' => '開始時間は必ず入力して下さい。',
            'time_from_alternative_2' => 'nullable',
            'time_from_alternative_3' => 'nullable',
            'time_to_alternative_1' => '終了時間は開始時間よりも遅い時間を入力して下さい。',
            'time_to_alternative_2' => '終了時間は開始時間よりも遅い時間を入力して下さい。',
            'time_to_alternative_3' => '終了時間は開始時間よりも遅い時間を入力して下さい。',
            'status' => 'nullable',
        ];
    }
}
