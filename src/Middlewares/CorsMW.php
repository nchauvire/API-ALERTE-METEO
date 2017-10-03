<?php
namespace Src\Middlewares;

use Monolog\Logger;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;
use Slim\Router;

class CorsMW
{

    /**
     * CheckEnvMW constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {

    }

    public function __invoke(Request $request,Response $response,$next)
    {

        /**
         * @var Route $route
         */
        $this->cors();
        return $next($request,$response);
    }


    private function cors()
    {
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET,POST,PUT,OPTIONS,DELETE");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        }
    }

}