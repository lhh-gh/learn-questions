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
use App\Event\UserSignuped;
use App\Exception\BusinessException;
use App\Model\User;
use App\Model\UserDynamic;
use App\Service\Instance\JwtInstance;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;
use Throwable;

class UserService extends Service
{
    #[Inject]
    private EventDispatcherInterface $eventDispatcher;

    public function signup(array $params)
    {
        // 入库
        Db::beginTransaction();
        try {
            $model = new User();
            $model->email = $params['email'];
            $model->password = password_hash($params['password'], PASSWORD_DEFAULT);
            // 图片路径取决于各自保存在 cdn 的路径
            $model->pic = 'images/avatar/' . rand(1, 382) . '.jpg';
            $model->nickname = 'api_' . rand(1, 99) . date('Hi');
            $model->save();

            // 同步
            $dynamicModel = new UserDynamic();
            $dynamicModel->uid = $model->id;
            $dynamicModel->save();

            Db::commit();
        } catch (Throwable $ex) {
            Db::rollBack();
            $this->logger->error($ex->getMessage());
            throw new BusinessException(ErrorCode::SERVER_ERROR);
        }

        // 获取token
        $token = JwtInstance::instance()->encode($model);
        $userInfo = JwtInstance::instance()->getUser();

        // 事件触发
        $this->eventDispatcher->dispatch(new UserSignuped($userInfo));

        return [$userInfo, $token];
    }
}
