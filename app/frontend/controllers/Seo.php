<?php


namespace Yabasi\Frontend\Controllers;

use Phalcon\Mvc\Model;
use Yabasi\Brand;
use Yabasi\Cats;
use Yabasi\Content;
use Yabasi\Product;
use Yabasi\Settings;
use Yabasi\Tags;

class Seo extends Model {

    public static function getTitle($id = false, $page = false) {
        if ($page == 'index') {
            return '<title>'.self::titlehome().'</title>';
        } else if ($page == 'cats') {
            return '<title>'.self::seotitle($page, $id).' - '.self::titlehome().'</title>';
        } else if ($page == 'brand') {
            return '<title>'.self::seotitle($page, $id).' - '.self::titlehome().'</title>';
        } else if ($page == 'user') {
            return '<title>Hesabım - '.self::titlehome().'</title>';
        } else if ($page == 'basket') {
            return '<title>Sepet ve Ödeme İşlemleri - '.self::titlehome().'</title>';
        } else if ($page == 'campaign') {
            return '<title>Tüm Fırsatlar - '.self::titlehome().'</title>';
        } else if ($page == 'tumurunler') {
            return '<title>Tüm Ürünler - '.self::titlehome().'</title>';
        } else if ($page == 'tags') {
            return '<title>'.self::seotitle($page, $id).' - '.self::titlehome().'</title>';
        } else if ($page == 'product') {
            return '<title>'.self::seotitle($page, $id).' - '.self::titlehome().'</title>';
        } else if ($page == 'content') {
            return '<title>'.self::seotitle($page, $id).' - '.self::titlehome().'</title>';
        } else if ($page == 'search') {
            return '<title>Arama Sonuçları - '.self::titlehome().'</title>';
        }
    }

    public static function getKeyword($id = false, $page = false) {
        if ($page == 'index') {
            return '<meta name="keywords" content="'.self::keywordhome().'" />';
        } else if($page == 'cats') {
            return '<meta name="keywords" content="'.self::seokeyword($page, $id).'" />';
        } else if($page == 'product') {
            return '<meta name="keywords" content="'.self::seokeyword($page, $id).'" />';
        } else if($page == 'brand') {
            return '<meta name="keywords" content="'.self::seokeyword($page, $id).'" />';
        } else if($page == 'content') {
            return '<meta name="keywords" content="'.self::seokeyword($page, $id).'" />';
        } else if($page == 'basket') {
            return '<meta name="keywords" content="'.self::keywordhome().'" />';
        } else if($page == 'campaign') {
            return '<meta name="keywords" content="'.self::keywordhome().'" />';
        } else if($page == 'tumurunler') {
            return '<meta name="keywords" content="'.self::keywordhome().'" />';
        } else if($page == 'tags') {
            return '<meta name="keywords" content="'.self::seokeyword($page, $id).'" />';
        } else if($page == 'search') {
            return '<meta name="keywords" content="'.self::keywordhome().'" />';
        } else if($page == 'user') {
            return '<meta name="keywords" content="'.self::keywordhome().'" />';
        }
    }

    public static function getDescription($id = false, $page = false) {
        if ($page == 'index') {
            return '<meta name="description" content="'.self::descriptionhome().'" />';
        } else if ($page == 'user') {
            return '<meta name="description" content="'.self::descriptionhome().'" />';
        } else if ($page == 'basket') {
            return '<meta name="description" content="'.self::descriptionhome().'" />';
        } else if ($page == 'campaign') {
            return '<meta name="description" content="'.self::descriptionhome().'" />';
        } else if ($page == 'tumurunler') {
            return '<meta name="description" content="'.self::descriptionhome().'" />';
        } else if ($page == 'search') {
            return '<meta name="description" content="'.self::descriptionhome().'" />';
        } else if ($page == 'product') {
            return '<meta name="description" content="'.self::seodescription($page, $id).'" />';
        } else if ($page == 'cats') {
            return '<meta name="description" content="'.self::seodescription($page, $id).'" />';
        } else if ($page == 'brand') {
            return '<meta name="description" content="'.self::seodescription($page, $id).'" />';
        } else if ($page == 'content') {
            return '<meta name="description" content="'.self::seodescription($page, $id).'" />';
        } else if ($page == 'tags') {
            return '<meta name="description" content="'.self::seodescription($page, $id).'" />';
        }
    }

    public static function titlehome() {
        $seo_home = Settings::findFirst('name="seo_home"');
        if ($seo_home) {
            $parse_home = json_decode($seo_home->getValue(), true);
            return $parse_home['title'];
        }
    }

    public static function descriptionhome() {
        $seo_home = Settings::findFirst('name="seo_home"');
        if ($seo_home) {
            $parse_home = json_decode($seo_home->getValue(), true);
            return $parse_home['description'];
        }
    }

    public static function keywordhome() {
        $seo_home = Settings::findFirst('name="seo_home"');
        if ($seo_home) {
            $parse_home = json_decode($seo_home->getValue(), true);
            return $parse_home['keyword'];
        }
    }

    public static function seodescription($table = false, $id = false) {
        if ($table && is_numeric($id)) {
            if ($table == 'product') {
                $data = Product::findFirst($id);
                if ($data) {
                    if ($data->getDescription()) {
                        return $data->getDescription();
                    } else {
                        return self::descriptionhome();
                    }
                }
            } else if ($table == 'cats') {
                $data = Cats::findFirst($id);
                if ($data) {
                    if ($data->getDescription()) {
                        return $data->getDescription();
                    } else {
                        return self::descriptionhome();
                    }
                }
            } else if ($table == 'brand') {
                $data = Brand::findFirst($id);
                if ($data) {
                    if ($data->getDescription()) {
                        return $data->getDescription();
                    } else {
                        return self::descriptionhome();
                    }
                }
            } else if ($table == 'content') {
                $data = Content::findFirst($id);
                if ($data) {
                    if ($data->getDescription()) {
                        return $data->getDescription();
                    } else {
                        return self::descriptionhome();
                    }
                }
            } else if ($table == 'tags') {
                $data = Tags::findFirst($id);
                if ($data) {
                    if ($data->getDescription()) {
                        return $data->getDescription();
                    } else {
                        return self::descriptionhome();
                    }
                }
            }
        }
    }

    public static function seokeyword($table = false, $id = false) {
        if ($table && is_numeric($id)) {
            if ($table == 'product') {
                $data = Product::findFirst($id);
                if ($data) {
                    if ($data->getKeyword()) {
                        return $data->getKeyword();
                    } else {
                        return self::keywordhome();
                    }
                }
            } else if ($table == 'cats') {
                $data = Cats::findFirst($id);
                if ($data) {
                    if ($data->getKeyword()) {
                        return $data->getKeyword();
                    } else {
                        return self::keywordhome();
                    }
                }
            } else if ($table == 'brand') {
                $data = Brand::findFirst($id);
                if ($data) {
                    if ($data->getKeyword()) {
                        return $data->getKeyword();
                    } else {
                        return self::keywordhome();
                    }
                }
            } else if ($table == 'content') {
                $data = Content::findFirst($id);
                if ($data) {
                    if ($data->getKeyword()) {
                        return $data->getKeyword();
                    } else {
                        return self::keywordhome();
                    }
                }
            } else if ($table == 'tags') {
                $data = Tags::findFirst($id);
                if ($data) {
                    if ($data->getKeyword()) {
                        return $data->getKeyword();
                    } else {
                        return self::keywordhome();
                    }
                }
            }
        }
    }

    public static function seotitle($table = false, $id = false) {
        if ($table && is_numeric($id)) {
            if ($table == 'product') {
                $data = Product::findFirst($id);
                if ($data) {
                    if ($data->getSeoTitle()) {
                        return $data->getSeoTitle();
                    } else {
                        return $data->getName();
                    }
                }
            } else if ($table == 'cats') {
                $data = Cats::findFirst($id);
                if ($data) {
                    if ($data->getSeoTitle()) {
                        return $data->getSeoTitle();
                    } else {
                        return $data->getName();
                    }
                }
            } else if ($table == 'brand') {
                $data = Brand::findFirst($id);
                if ($data) {
                    if ($data->getSeoTitle()) {
                        return $data->getSeoTitle();
                    } else {
                        return $data->getName();
                    }
                }
            } else if ($table == 'content') {
                $data = Content::findFirst($id);
                if ($data) {
                    if ($data->getSeoTitle()) {
                        return $data->getSeoTitle();
                    } else {
                        return $data->getName();
                    }
                }
            } else if ($table == 'tags') {
                $data = Tags::findFirst($id);
                if ($data) {
                    if ($data->getSeoTitle() != '') {
                        return $data->getSeoTitle();
                    } else {
                        return $data->getName();
                    }
                }
            }
        }
    }
}