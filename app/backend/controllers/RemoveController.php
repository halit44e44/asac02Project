<?php
namespace Yabasi\Backend\Controllers;
use Yabasi\Auth;
use Yabasi\Backend\Controllers\ControllerBase;
use Yabasi\Cats;
use Yabasi\Images;
use Yabasi\Menu;
use Yabasi\Product;

class RemoveController extends ControllerBase {

    public function initialize() {
        self::isAuth();
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

    }

    public function indexAction() {
        echo json_encode(array('code' => 200, 'message' => 'Auth is required!'));
    }

    public function doAction() {
        $this->view->disable();

        $id = $this->request->getQuery("id");
        $table = $this->request->getQuery('table');
        $yeni_id = $this->request->getQuery('yeni_id');
        if (!$table) {
            echo json_encode(array('code' => 404, 'message' => 'Missing parameter!'));
            die();
        }

        $tables = array(
            'address',
            'settings',
            'bank',
            'content',
            'contentcats',
            'district',
            'cargo',
            'cats',
            'user',
            'usergroup',
            'quarter',
            'brand',
            'pnotification',
            'feature',
            'city',
            'town',
            'country',
            'variant',
            'comment',
            'product',
            'images',
            'virtualpos',
            'supplier',
            'vouchers',
            'tags'
        );
        if (in_array($table, $tables)) {
            if (is_numeric($id)) {
                $remove = self::db($table)::findFirst($id);
                if ($this->isAuthorityRemove($table)=="noauth"){
                    echo json_encode(array('status' => "noauth"));
                } else if ($remove) {

                    /* eğer usergrouop siliyorsak ilişkili auth verileri de silinecek */
                    if ($table == 'usergroup') {
                        $auth = Auth::find('group_id='.$id);
                        if (count($auth) > 0) {
                            $auth->delete();
                        }
                    }if ($table=="cats"){
                        $images=Images::find("meta_key='category' and content_id=".$id);
                        $menu=Menu::find("cats_id=".$id);
                        $cats=Cats::find('top_id='.$id);
                        $collection = Product::find(array(
                            'cats_id like ("%'.$id.'%")'
                        ));
                        if ($collection->count()>0){
                            foreach ($collection as $post){
                                $implode=explode(',',$post->getCatsId());
                                foreach ($implode as $value){
                                    if ($value==$id){
                                        $post->setCatsId(str_replace($id,$yeni_id,$post->getCatsId()));
                                        $post->save();
                                    }
                                }
                            }
                        }
                        if ($menu->count()>0){
                            foreach ($menu as $menu){
                                $menu->setCatsId($yeni_id);
                                $menu->save();
                            }
                        }
                        if ($images->count()>0){
                            foreach ($images as $images){
                                $images->setCatsId($yeni_id);
                                $images->save();
                            }
                        }
                        if ($cats->count()>0){
                            foreach ($cats as $cats){
                                if ($cats->getTopId()==$yeni_id){
                                    $cats->setTopId(0);
                                    $cats->save();
                                }else{
                                    $cats->setTopId($yeni_id);
                                    $cats->save();
                                }

                            }
                        }
                    }
                    if ($remove->delete()){
                        $remove->delete();
                        $this->log($this->cookies->get('user'),$id,$table,"delete");
                    }
                    echo json_encode(array('status' => true));
                } else {
                    echo json_encode(array('status' => false));
                }
            }
        }
    }


}