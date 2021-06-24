<?php
declare(strict_types=1);

namespace Yabasi\Frontend\Controllers;


use Yabasi\Product;

class SonucController extends ControllerBase {

    public function initialize() {
        self::getAuth();
        self::navMenu();
        self::sepetcount();
        self::getSessionId();
        self::getLanguage();
        self::language();
        self::getactivetheme();
        self::getMetas();
        $this->view->page = 'search';
    }

    public function indexAction() {
        $query = $this->request->getQuery('q');
        if ($query) {
            $this->view->query = $query;

            $pro = Product::find(
                [
                    "name LIKE :name: OR search_keywords LIKE :search_keywords:",
                    "bind" => [
                        'name' => '%' . $query .'%',
                        'search_keywords' => '%' . $query .'%',
                    ]
                ]
            );

            if (count($pro) > 0) {
                $this->view->products = $pro;
                $this->view->total_products = count($pro);

                $total_result = count($pro);
                $perpage = 10;
                $total_page = round($total_result / $perpage);
                $this->view->total_page = $total_page;

            }
        } else {
            $this->response->redirect('');
        }
    }

    public function sonucAction() {

    }

}

