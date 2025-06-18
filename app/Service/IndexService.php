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

namespace App\Service;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;

class IndexService
{
    public function info(int $id)
    {
        if ($id <= 0) {
            throw new BusinessException(ErrorCode::PARAMS_ID_INVALID, 'id无效');
        }

        return ['info' => 'data info'];
    }
}
