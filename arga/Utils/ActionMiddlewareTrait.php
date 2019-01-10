<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/19/18
 * Time: 12:47 PM
 */

namespace Arga\Utils;

trait ActionMiddlewareTrait
{
    protected $_actionMiddleware = [];

    /**
     * Runtime Middleware
     *
     * @param array $middlewares
     */
    protected function actionMiddleware(array $middlewares): void
    {
        $this->_actionMiddleware = $middlewares;

        $route = request()->route();

        if ($route === null) {
            return;
        }

        $methodName = $route->getActionMethod();
//        dd($this->_actionMiddleware, $methodName);
        $middleware = array_get($this->_actionMiddleware, $methodName);
//        dd($middleware);
        if (!$middleware) {
            return;
        }


        $this->middleware('permission:'.$middleware);
    }
}
