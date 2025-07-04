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

namespace App\Controller;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Request\LoginRequest;
use App\Request\SignUpRequest;
use App\Service\Instance\JwtInstance;
use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Swagger\Annotation as SA;
#[SA\HyperfServer('http')]
class UserController extends AbstractController
{
    #[Inject]
    protected UserService $userService;

    #[SA\Post(path: '/user/singup', description: '注册接口', tags: ['用户'], summary: ' POST 表单示例')]
    public function signup(SignUpRequest $signUpRequest)
    {
        // 获取已验证的数据
        $validated = $signUpRequest->validated();

        [$user, $token] = $this->userService->signup($validated);

        return $this->response->success([
            'user' => $user,
            'token' => $token,
        ]);
    }


    public function login(LoginRequest $loginRequest)
    {
        $validated = $loginRequest->validated();

        [$user, $token] = $this->userService->login($validated['email'], $validated['password']);

        return $this->response->success([
            'user' => $user,
            'token' => $token,
        ]);
    }


    public function test()
    {
        $token = $this->request->input('token');


        $jwtInstance = JwtInstance::instance();
        try {
            $jwtInstance->decode($token);
        } catch (\Throwable $e) {
        }

        $uid = $jwtInstance->getId();
        if (empty($uid)) {
            throw new BusinessException(ErrorCode::FORBIDDEN);
        }

        return $this->response->success([
            'uid' => $uid,
        ]);
    }

}