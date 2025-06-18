<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class SignUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|verifyCode', // 优先校验验证码
            'email' => 'required|email|unique:users,email', // 邮箱唯一
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string|same:password',
        ];
    }
}
