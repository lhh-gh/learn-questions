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

use App\Components\Mail;
use Hyperf\Context\ApplicationContext;

class IndexService
{
    public function info()
    {
        $startTime = microtime(true);

        $mail = ApplicationContext::getContainer()->get(Mail::class);
        // ->to 这里填写目标邮箱，大家自己更改，不要都写我的了
        $mail->to('2043821670@qq.com')->send('邮件测试标题', '<b style="color: #f00;">邮件测试内容</b>');

        $runTime = '耗时: ' . (microtime(true) - $startTime) . ' s';

        return ['runtime' => $runTime];
    }
}
