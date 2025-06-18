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

use App\Service\IndexService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

#[AutoController]
class IndexController extends AbstractController
{
    /**
     * @var IndexService
     */
    #[Inject]
    public $indexService;

    public function info()
    {
        $id = (int) $this->request->input('id', 0);

        return $this->response->success($this->indexService->info($id));
    }

    public function index()
    {
        return $this->response->success(['info' => 'data info']);
    }
}
