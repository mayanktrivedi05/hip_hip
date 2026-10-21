<?php

namespace App\Http\Requests;

use App\Models\Wallet;
use Illuminate\Foundation\Http\FormRequest;

class TransferFundsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'from_wallet' => ['required', 'string', 'in:'.Wallet::TYPE_PROFIT.','.Wallet::TYPE_REFERRAL],
            'to_wallet' => ['required', 'string', 'in:'.Wallet::TYPE_MAIN],
            'amount' => ['required', 'numeric', 'gt:0', 'max:100000000'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'from_wallet.required' => 'Please select the wallet to transfer from.',
            'from_wallet.in' => 'Internal transfers are only permitted from Profit or Referral wallets.',
            'to_wallet.required' => 'Please select the destination wallet.',
            'to_wallet.in' => 'Internal transfers can only be deposited into your Main Wallet.',
            'amount.required' => 'Please enter the amount you wish to transfer.',
            'amount.numeric' => 'The transfer amount must be a valid number.',
            'amount.gt' => 'The transfer amount must be greater than zero.',
        ];
    }
}
