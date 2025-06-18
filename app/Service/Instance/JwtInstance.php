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

namespace App\Service\Instance;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\User;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Throwable;

class JwtInstance extends Instance
{
    public const KEY = 'questions';

    public const ALG = 'HS256';

    public const EXPIRE_TIME = 3600 * 24 * 30;

    public ?int $id = null;

    public ?array $user = null;

    /**
     * @function: encode
     * @Desc:即对用户 id 编码，生成 token
     * @return string
     */
    public function encode(User $user)
    {
        $this->id = $user->id;
        return JWT::encode(['id' => $user->id, 'exp' => time() + self::EXPIRE_TIME], self::KEY, self::ALG);
    }

    /**
     * @function: decode
     * @Desc:解码 token，这个用于判断客户端传递 token 是否有效
     * @return $this
     */
    public function decode(string $token): self
    {
        try {
            $decoded = (array) JWT::decode($token, new Key(self::KEY, self::ALG));
        } catch (ExpiredException $exception) {
            throw new BusinessException(ErrorCode::TOKEN_EXPIRED);
        } catch (Throwable $exception) {
            throw new BusinessException(ErrorCode::SERVER_ERROR, $exception->getMessage());
        }
        if ($id = $decoded['id']) {
            $this->id = $id;
            $this->user = $this->getUser();
        }
        return $this;
    }

    /**
     * @function: getId
     * @Desc:获取协程上下文的用户 id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @function: getUser
     * @Desc:获取协程上下文的用户信息，用户信息通过 User::find($id) 获取
     */
    public function getUser(): ?array
    {
        if ($this->user === null) {
            if (! empty($id = $this->getId())) {
                if ($user = User::find($id)) {
                    $this->user = $user->toArray();
                }
            }
        }
        return $this->user;
    }
}
