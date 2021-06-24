<?php

$router = $di->getRouter();

foreach ($application->getModules() as $key => $module) {
    $namespace = preg_replace('/Module$/', 'Controllers', $module['className']);

    $router->add('/'.$key.'/:params', [
        'namespace' => $namespace,
        'module' => $key,
        'controller' => 'index',
        'action' => 'index',
        'params' => 1
    ])->setName($key);

    $router->add('/'.$key.'/:controller/:params', [
        'namespace' => $namespace,
        'module' => $key,
        'controller' => 1,
        'action' => 'index',
        'params' => 2
    ]);

    $router->add('/'.$key.'/:controller/:action/:params', [
        'namespace' => $namespace,
        'module' => $key,
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ]);

    $router->add(
        '/kategori/{slug}',
        [
            'controller' => 'kategori',
            'action'     => 'index',
            'param'  => 'sef',
            'sef'		 => 1
        ]
    );

    $router->add(
        '/etiket/{slug}',
        [
            'controller' => 'etiket',
            'action'     => 'index',
            'param'  => 'sef',
            'sef'		 => 1
        ]
    );

    $router->add(
        '/tum-firsatlar',
        [
            'controller' => 'firsatlar',
            'action'     => 'index',
            'param'      => 'sef',
            'sef'		 => 1
        ]
    );

    $router->add(
        '/tum-urunler',
        [
            'controller' => 'tumurunler',
            'action'     => 'index',
            'param'      => 'sef',
            'sef'		 => 1
        ]
    );

    $router->add(
        '/marka/{slug}',
        [
            'controller' => 'marka',
            'action'     => 'index',
            'param'  => 'sef',
            'sef'		 => 1
        ]
    );

    $router->add(
        '/urun/{slug}',
        [
            'controller' => 'urun',
            'action'     => 'detay',
            'sef'		 => 1
        ]
    );

    $router->add(
        '/sayfa/{slug}',
        [
            'controller' => 'sayfa',
            'action'     => 'index',
            'param'  => 'sef',
            'sef'		 => 1
        ]
    );
}

//$router->removeExtraSlashes(true);