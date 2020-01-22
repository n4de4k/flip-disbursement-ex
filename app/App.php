<?php
namespace app;

use libs\Router\iRouter;
class App {
    private $router;

    function __construct(iRouter $_router) {
        $this->router = $_router;
    }

    public function run() {
        $this->router->post('/transaction', 'Transaction::newTransaction');
        $this->router->get('/transaction', 'Transaction::checkTransaction');

        $this->router->handle();
    }

}