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

namespace App\Constants;

use Hyperf\Constants\Annotation\Constants;
use Hyperf\Constants\Annotation\Message;
use Hyperf\Constants\EnumConstantsTrait;

#[Constants]
enum ErrorCode: int
{
    use EnumConstantsTrait;

    #[Message('Server Error!')]
    case SERVER_ERROR = 500;

    #[Message('params.id_invalid')]
    case PARAMS_ID_INVALID = 100001;

    #[Message('mail.send_failed')]
    public const MAIL_SEND_FAILED = 100002;

    #[Message('mail.sent_frequently')]
    public const CODE_SENT_FREQUENTLY = 100003;

    #[Message('user.exists')]
    public const USER_EXISTS = 200001;
    //    public function getMessage(?array $translate = null): string
    //    {
    //        $arguments = [];
    //        if ($translate) {
    //            $arguments = [$translate];
    //        }
    //
    //        return $this->__call('getMessage', $arguments);
    //    }

    #[Message('form.error')]
    public const FORM_ERROR = 100006;

    #[Message('code.error')]
    public const CODE_ERROR = 100007;

    #[Message('code.expired')]
    public const CODE_EXPIRED = 10008;

    #[Message('token.expired')]
    public const TOKEN_EXPIRED = 10009;

    #[Message('user.not_exists')]
    const USER_NOT_EXISTS = 100010;

    #[Message('password.error')]
    const PASSWORD_ERROR = 100011;
    #[Message('forbidden')]
    const FORBIDDEN = 11111;

}
