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

namespace App\Exception\Handler;

use App\Components\Response;
use App\Exception\BusinessException;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

use function Hyperf\Config\config;

class AppExceptionHandler extends ExceptionHandler
{
    //    public function __construct(protected StdoutLoggerInterface $logger)
    //    {
    //    }
    //
    //    public function handle(Throwable $throwable, ResponseInterface $response)
    //    {
    //        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
    //        $this->logger->error($throwable->getTraceAsString());
    //        return $response->withHeader('Server', 'Hyperf')->withStatus(500)->withBody(new SwooleStream('Internal Server Error.'));
    //    }
    //
    //    public function isValid(Throwable $throwable): bool
    //    {
    //        return true;
    //    }

    protected $logger;

    /**
     * 响应对象（自定义的响应格式化类）.
     * @var Response
     */
    protected $response;

    public function __construct(ContainerInterface $container, Response $response)
    {
        $this->logger = $container->get(LoggerFactory::class)->get('exception');
        $this->response = $response;
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $formatter = ApplicationContext::getContainer()->get(FormatterInterface::class);
        // 业务异常类
        if ($throwable instanceof BusinessException) {
            return $this->response->fail($throwable->getCode(), $throwable->getMessage());
        }

        // HttpException
        if ($throwable instanceof HttpException) {
            return $this->response->fail($throwable->getStatusCode(), $throwable->getMessage());
        }

        $this->logger->error($formatter->format($throwable));

        return $this->response->fail(500, config('app_env') === 'dev' ? $throwable->getMessage() : 'Server Error');
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
