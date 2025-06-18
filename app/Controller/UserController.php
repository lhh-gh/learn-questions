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

use App\Request\SignUpRequest;
use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;

class UserController extends AbstractController
{
    #[Inject]
    protected UserService $userService;

    /**
     * 注册.
     * @return ResponseInterface
     */
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
}
