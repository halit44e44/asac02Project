<?php
declare(strict_types=1);

use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;


/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

$di->setShared('crypt', function() use($di) {
    $crypt = new \Phalcon\Crypt();
    $crypt->setKey('&Fef=hbdacaP_fAhwb_2-8Y_6Hkx@RF');
    return $crypt;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    return new $class($params);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});



/**
 * Configure the Volt service for rendering .volt templates
 */
$di->setShared('voltShared', function ($view) {
    $config = $this->getConfig();

    $volt = new VoltEngine($view, $this);


    $volt->setOptions([
        'path' => function($templatePath) use ($config) {
            $basePath = $config->application->appDir;
            if ($basePath && substr($basePath, 0, 2) == '..') {
                $basePath = dirname(__DIR__);
            }

            $basePath = realpath($basePath);
            $templatePath = trim(substr($templatePath, strlen($basePath)), '\\/');

            $filename = basename(str_replace(['\\', '/'], '_', $templatePath), '.volt') . '.php';

            $cacheDir = $config->application->cacheDir;
            if ($cacheDir && substr($cacheDir, 0, 2) == '..') {
                $cacheDir = __DIR__ . DIRECTORY_SEPARATOR . $cacheDir;
            }

            $cacheDir = realpath($cacheDir);

            if (!$cacheDir) {
                $cacheDir = sys_get_temp_dir();
            }

            if (!is_dir($cacheDir . DIRECTORY_SEPARATOR . 'volt')) {
                @mkdir($cacheDir . DIRECTORY_SEPARATOR . 'volt' , 0755, true);
            }

            return $cacheDir . DIRECTORY_SEPARATOR . 'volt' . DIRECTORY_SEPARATOR . $filename;
        }
    ]);

    $volt->getCompiler()->addFunction(
        'cargocity',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::cargocity(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'hediye',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::hediye(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'oldpricesepet',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::oldpricesepet(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'price',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::price(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'sepettoplam',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::sepettoplam(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'indirim',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::indirim(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'sepetStock',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::sepetStock(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'sepetVariant',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::sepetVariant(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'sepetVoucher',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::sepetVoucher(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'voucher',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::voucher(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'order',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::order(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'taksit',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::taksit(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'city',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::city(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'urunFiyat',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::urunFiyat(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'urunButton',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::urunButton(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'town',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::town(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'dist',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::dist(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'variant',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::variant(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'round',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::round(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'pricesepet',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::pricesepet(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'cargo',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::cargo(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'sepettotalprice',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::sepettotalprice(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'product',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::product(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'productImage',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::productImage(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'feature',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::feature(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'featureName',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::featureName(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'totalprice',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::totalprice(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'cats',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::cats(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'catsef',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::catsef(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'comment',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::comment(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'prodate',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::prodate(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'points',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::points(' . $id . ')';
        }
    );

    $volt->getCompiler()->addFunction(
        'oldprice',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::oldprice(' . $id . ')';
        }
    );

    $volt->getCompiler()->addFunction(
        'totaldiscount',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::totaldiscount(' . $id . ')';
        }
    );

    $volt->getCompiler()->addFunction(
        'socialmedia',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::socialmedia(' . $theme_id . ')';
        }
    );

    $volt->getCompiler()->addFunction(
        'socialmediaFace',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::socialmediaFace(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'socialmediaTwiter',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::socialmediaTwiter(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'socialmediaInstagram',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::socialmediaInstagram(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'socialmediaYoutube',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::socialmediaYoutube(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'socialmediaPinterest',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::socialmediaPinterest(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'footerBultenBasligi',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::footerBultenBasligi(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'footerCopyright',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::footerCopyright(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'footerMenu',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::footerMenu(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'sliderGecisTipi',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::sliderGecisTipi(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'sliderResimDegisme',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::sliderResimDegisme(' . $theme_id . ')';
        }
    );

    $volt->getCompiler()->addFunction(
        'sliderIleriGeriButon',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::sliderIleriGeriButon(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'renkTema',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::renkTema(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'renkButton',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::renkButton(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'renkButtonYazi',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::renkButtonYazi(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'renkTemaYazi',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::renkTemaYazi(' . $theme_id . ')';
        }
    );

    $volt->getCompiler()->addFunction(
        'setheight',
        function ($theme_id = false, $height = false) {
            if ($theme_id && $height) {
                return 'Yabasi\Frontend\Controllers\Themes::setheight('.$theme_id.',"'.$height.'")';
            } else {
                return false;
            }
        }
    );

    $volt->getCompiler()->addFunction(
        'renkMenuCizgi',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::renkMenuCizgi(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'renkMenuHover',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::renkMenuHover(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'renkMenuHoverKenar',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::renkMenuHoverKenar(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'renkMenuHoverYazi',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::renkMenuHoverYazi(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'sliderCerceveRengi',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::sliderCerceveRengi(' . $theme_id . ')';
        }
    );

    $volt->getCompiler()->addFunction(
        'paymentMethods',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Payment::paymentMethods()';
        }
    );
    $volt->getCompiler()->addFunction(
        'genelayarLogo',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::genelayarLogo(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'socialmediaLinkedin',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::socialmediaLinkedin(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'socialmediaWhatsapp',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::socialmediaWhatsapp(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'modalLogo',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::modalLogo(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'modalUrl',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::modalUrl(' . $theme_id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'socialmediaHemenara',
        function ($theme_id) {
            return 'Yabasi\Frontend\Controllers\Themes::socialmediaHemenara(' . $theme_id . ')';
        }
    );

    $volt->getCompiler()->addFunction(
        'title',
        function ($id, $page) {
            return 'Yabasi\Frontend\Controllers\Seo::getTitle('.$id.', "'.$page.'")';
        }
    );

    $volt->getCompiler()->addFunction(
        'keyword',
        function ($id, $page) {
            return 'Yabasi\Frontend\Controllers\Seo::getKeyword('.$id.', "'.$page.'")';
        }
    );

    $volt->getCompiler()->addFunction(
        'description',
        function ($id, $page) {
            return 'Yabasi\Frontend\Controllers\Seo::getDescription('.$id.', "'.$page.'")';
        }
    );

    $volt->getCompiler()->addFunction(
        'contentbycatid',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::contentbycatid('.$id.')';
        }
    );

    $volt->getCompiler()->addFunction(
        'contentgallery',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::contentgallery('.$id.')';
        }
    );

    $volt->getCompiler()->addFunction(
        'getRelatedPro',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::getRelatedPro('.$id.')';
        }
    );

    $volt->getCompiler()->addFunction(
        'getGiftPro',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::getGiftPro('.$id.')';
        }
    );

    $volt->getCompiler()->addFunction(
        'getRecommendetPro',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::getRecommendetPro('.$id.')';
        }
    );

    $volt->getCompiler()->addFunction(
        'havaletoplam',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::havaletoplam(' . $id . ')';
        }
    );
    $volt->getCompiler()->addFunction(
        'havalekontrol',
        function ($id) {
            return 'Yabasi\Frontend\Controllers\Functions::havalekontrol(' . $id . ')';
        }
    );


    return $volt;
});
