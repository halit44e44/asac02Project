<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

//error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Include general services
     */
    require APP_PATH . '/config/services.php';

    /**
     * Include web environment specific services
     */
    require APP_PATH . '/config/services_web.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new Application($di);

    /**
     * Register application modules
     */
    $application->registerModules([
        'frontend' => ['className' => 'Yabasi\Frontend\Module'],
        'backend' => ['className' => 'Yabasi\Backend\Module'],
        'api' => ['className' => 'Yabasi\Api\Module'],
    ]);

    /**
     * Include routes
     */
    require APP_PATH . '/config/routes.php';

    //echo $application->handle($_SERVER['REQUEST_URI'])->getContent();
    echo $application->handle($_GET['_url'] ?? '/')->getContent();
} catch (\Exception $e) {

    echo $e;

    echo "<style>* {-webkit-box-sizing: border-box; box-sizing: border-box; }
    body { padding: 0; margin: 0; }
    #notfound {position: relative;height: 100vh;}
    #notfound .notfound-bg {position: absolute;width: 100%;height: 100%;background-image: url('https://colorlib.com/etc/404/colorlib-error-404-11/img/bg.jpg');background-size: cover; }
    #notfound .notfound-bg:after { content: ''; position: absolute; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.25); }
    #notfound .notfound { position: absolute; left: 50%; top: 50%; -webkit-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%); }
    #notfound .notfound:after { content: ''; position: absolute; left: 50%; top: 50%; -webkit-transform: translate(-50% , -50%); -ms-transform: translate(-50% , -50%); transform: translate(-50% , -50%); width: 100%; height: 600px; background-color: rgba(255, 255, 255, 0.7); -webkit-box-shadow: 0px 0px 0px 30px rgba(255, 255, 255, 0.7) inset; box-shadow: 0px 0px 0px 30px rgba(255, 255, 255, 0.7) inset; z-index: -1; }
    .notfound { max-width: 600px; width: 100%; text-align: center; padding: 30px; line-height: 1.4; }
    .notfound .notfound-404 { position: relative; height: 200px; }
    .notfound .notfound-404 h1 { font-family: 'Passion One', cursive; position: absolute; left: 50%; top: 50%; -webkit-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%); font-size: 220px; margin: 0px; color: #222225; text-transform: uppercase; }
    .notfound h2 { font-family: 'Muli', sans-serif; font-size: 26px; font-weight: 400; text-transform: uppercase; color: #222225; margin-top: 26px; margin-bottom: 20px; }
    .notfound-search { position: relative; padding-right: 120px; max-width: 420px; width: 100%; margin: 30px auto 20px; }
    .notfound-search input { font-family: 'Muli', sans-serif; width: 100%; height: 40px; padding: 3px 15px; color: #fff; font-weight: 400; font-size: 18px; background: #222225; border: none; }
    .notfound-search button { font-family: 'Muli', sans-serif; position: absolute; right: 0px; top: 0px; width: 120px; height: 40px; text-align: center; border: none; background: #ff00b4; cursor: pointer; padding: 0; color: #fff; font-weight: 400; font-size: 16px; text-transform: uppercase; }
    .notfound a { font-family: 'Muli', sans-serif; display: inline-block; font-weight: 400; text-decoration: none; background-color: transparent; color: #222225; text-transform: uppercase; font-size: 14px; }
    .notfound-social { margin-bottom: 15px; }
    .notfound-social>a { display: inline-block; height: 40px; line-height: 40px; width: 40px; font-size: 14px; color: #fff; background-color: #222225; margin: 3px; -webkit-transition: 0.2s all; transition: 0.2s all; }
    .notfound-social>a:hover { color: #fff; background-color: #ff00b4; }
    @media only screen and (max-width: 480px) { .notfound .notfound-404 { height: 146px; } .notfound .notfound-404 h1 { font-size: 146px; } .notfound h2 { font-size: 22px; } }
    </style>";
    echo '<!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->
    </head><body><div id="notfound"><div class="notfound-bg"></div><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>Sayfa bulunamadı!</h2></div></div>';

}
