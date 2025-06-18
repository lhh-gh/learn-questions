<?php

declare(strict_types=1);


namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;

#[AutoController]
class IndexController extends AbstractController
{
    public function info()
    {
        $id = (int)$this->request->input('id', 0);
        if ($id > 0) {
            return $this->response->success(['info' => 'data info']);
        } else {
            return $this->response->fail(500, 'id无效');
        }
    }
    public function index()
    {
        return $this->response->success(['info' => 'data info']);
    }
}
