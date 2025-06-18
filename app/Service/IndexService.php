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

use App\Amqp\Producer\MailProducer;
use Hyperf\Amqp\Producer;
use Hyperf\Context\ApplicationContext;

class IndexService
{
    public function info()
    {
        $startTime = microtime(true);

        $mailInfo = [
            'to' => '2043821670@qq.com',
            'subject' => '邮件测试标题111',
            'body' => '<b style="color: #f00;">邮件测试内容222</b>',
        ];
        $message = new MailProducer($mailInfo);
        $producer = ApplicationContext::getContainer()->get(Producer::class);
        $producer->produce($message);

        $runTime = '耗时: ' . (microtime(true) - $startTime) . ' s';

        return ['time' => date('Y-m-d H:i:s'), 'runtime' => $runTime];
    }
}
