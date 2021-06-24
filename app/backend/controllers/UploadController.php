<?php


namespace Yabasi\Backend\Controllers;

use Gumlet\ImageResize;
use Gumlet\ImageResizeException;
use Phalcon\Security\Random;
use Yabasi\Images;
use Yabasi\Themecontent;
use Yabasi\User;

class UploadController extends ControllerBase {

    function permalink($str, $options = array()){
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true
        );

        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        if ($options['transliterate']){
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
        $str = trim($str, $options['delimiter']);
        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }


    public function indexAction() {
        $this->view->disable();
        header('Content-Type: application/json');
        echo json_encode(array('code' => 404, 'message' => 'Missing parameter!'));
        die();
    }

    public function setAction() {

        $this->view->disable();

        $id = $this->request->getPost('id');
        $table = $this->request->getPost('table');

        if ($this->request->hasFiles()) {
            $location = BASE_PATH.'/public/media/'.$table.'/';
        }

        if (!$id) {
            $id = 0;
        }
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            foreach ($this->request->getUploadedFiles() as $file) {
                $ext = $file->getExtension();
                //$name = self::getRandomFileName().'.'.$ext;

                $file_name = $this->getFileName($id, $table);
                $name = $file_name.'.'.$ext;

                $accept_ext = array('jpg', 'jpeg', 'png', 'gif');

                if (in_array($ext, $accept_ext)) {
                    if (is_numeric($id)) {
                        if ($file->moveTo($location . $name)) {
                            $insert = new Images();
                            $insert->setContentId($id);
                            $insert->setMetaKey($table);
                            $insert->setMetaValue($name);
                            $insert->setShowcase(0);
                            $insert->setRow(0);
                            $insert->setCreatedAt(self::getnow());
                            $insert->setUpdatedAt(self::getnow());
                            $insert->setStatus(1);
                            $insert->save();

                            $this->resizeImage($id , $table, $file_name, $ext);

                            if ($table == 'theme_content') {
                                $update = Themecontent::findFirst('name="logo"');
                                if ($update) {
                                    $update->setValue($name);
                                    $update->setUpdatedAt(self::getnow());
                                    $update->update();
                                } else {
                                    $insert = new Themecontent();
                                    $insert->setName('logo');
                                    $insert->setValue($name);
                                    $insert->setThemeId($id);
                                    $insert->setCreatedAt(self::getnow());
                                    $insert->setUpdatedAt(self::getnow());
                                    $insert->setStatus(1);
                                }

                            }

                        }
                    }
                }
            }
        }


        $images = Images::find('content_id = '. $id. ' and meta_key = "'. $table.'"');
        if ($images) {
            $returned = '';

            foreach ($images as $image) {
                $checked  = '';
                if ($image->getShowcase() == 1) {
                    $checked = 'checked="true"';
                }

                $ext = explode(".", $image->getMetaValue());
                $ext = $ext[1];

                $returned .= '<div class="card card-custom gutter-b" id="image_'.$image->getId().'"><i class="fa fa-check cardi dn" id="cardi_'.$image->getId().'"></i> <div class="card-body"> <div class="d-flex"> <div class="flex-shrink-0 mr-7"> <div class="symbol symbol-50 symbol-lg-120"> <img src="media/'.$table.'/'.$image->getMetaValue().'" style="object-fit: cover;" /> </div> </div> <div class="flex-grow-1"> <form id="form_'.$image->getId().'"> <input type="hidden" class="lastid" name="id" value="'.$image->getId().'" /> <input type="hidden" name="extension" value="'.$ext.'" /> <div class="d-flex align-items-center flex-wrap justify-content-between row"> <div class="col-md-10"> <div class="form-group"> <label>Dosya ismi</label> <input type="text" class="form-control" name="name" value="'.preg_replace('/\\.[^.\\s]{3,4}$/', '', $image->getMetaValue()).'"/> </div> </div> <div class="col-md-2"> <div class="form-group"> <label>Sıra</label> <input type="number" class="form-control" name="row" value="'.$image->getRow().'" min="1"/> </div> </div> <div class="col-md-6"> <label class="checkbox"> <input type="checkbox" name="showcase" value="1" data-image="media/'.$table.'/'.$image->getMetaValue().'" '.$checked.'> <span class="mr-3"></span>Ön tanımlı görsel</label> </div> <div class="col-md-6 text-right"> <button type="button" onclick="removeImage(this)" data-id="'.$image->getId().'" class="btn btn-light-danger mr-2">Kaldır</button> <button type="button" class="btn btn-light-primary mr-2" data-id="'.$image->getId().'" onclick="updateImage(this)">Kaydet</button> </div> </div> </form> </div> </div> </div> </div>';
            }
        }
        echo $returned;


    }

    public function resizeImage($id , $table, $file_name, $ext) {
        if ($id && $table && $file_name && $ext) {
            $orj    = 'media/'.$table.'/'.$file_name.'.'.$ext;

            $image100x120 = 'media/'.$table.'/mini/100x120_'.$file_name.'.'.$ext;
            $image65x95 = 'media/'.$table.'/mini/65x95_'.$file_name.'.'.$ext;
            $image50x60 = 'media/'.$table.'/mini/50x60_'.$file_name.'.'.$ext;

            require '../vendor/autoload.php';


            try {
                $image = new ImageResize($orj);
                $image->crop(100, 120);
                $image->save($image100x120);

                $image = new ImageResize($orj);
                $image->crop(65, 95);
                $image->save($image65x95);

                $image = new ImageResize($orj);
                $image->crop(50, 60);
                $image->save($image50x60);
            } catch (ImageResizeException $e) {
                echo $e;
            }

            return true;


        }

    }

    public function updateAction() {
        $this->view->disable();
        $user = User::findFirst($this->getAuthId());

        if ($user->getGroupId() == 3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $name      = $this->request->getPost('name');
                    $row       = $this->request->getPost('row');
                    $showcase  = $this->request->getPost('showcase');
                    $id        = $this->request->getPost('id');
                    $extension = $this->request->getPost('extension');

                    if (is_numeric($id)) {
                        $update = Images::findFirst($id);

                        if ($update) {

                            $oldFileName = $update->getMetaValue();

                            $namewithExt = $name.'.'.$extension;

                            $check = Images::findFirst('id!='.$id.' and meta_value="'.$namewithExt.'"');
                            if ($check) {
                                echo '{"status": "same", "message": "Düzenlemek istediğiniz isimde bir resim zaten var."}';
                                exit;
                            }

                            if ($namewithExt != $oldFileName) {
                                $oldFileDir = BASE_PATH.'/public/media/'.$update->getMetaKey().'/'.$oldFileName;
                                $newFileDir = BASE_PATH.'/public/media/'.$update->getMetaKey().'/'.$this->permalink($name).'.'.$extension;
                                $fileName = $oldFileName;

                                $old100x120 = BASE_PATH.'/public/media/'.$update->getMetaKey().'/mini/100x120_'.$update->getMetaValue();
                                $old69x95   = BASE_PATH.'/public/media/'.$update->getMetaKey().'/mini/65x95_'.$update->getMetaValue();
                                $old50x60   = BASE_PATH.'/public/media/'.$update->getMetaKey().'/mini/50x60_'.$update->getMetaValue();

                                rename($old50x60, BASE_PATH.'/public/media/'.$update->getMetaKey().'/mini/50x60_'.$this->permalink($name).'.'.$extension);
                                rename($old69x95, BASE_PATH.'/public/media/'.$update->getMetaKey().'/mini/65x95_'.$this->permalink($name).'.'.$extension);
                                rename($old100x120, BASE_PATH.'/public/media/'.$update->getMetaKey().'/mini/100x120_'.$this->permalink($name).'.'.$extension);

                                if(!file_exists($oldFileDir)) {
                                    echo '{"status": "failed", "message": "Düzenlemek istediğiniz resim bulunamadı."}';
                                    exit;
                                }

                                if(rename($oldFileDir, $newFileDir)) {
                                    $fileName = $this->permalink($name);
                                } else {
                                    echo '{"status": "failed", "message": "Düzenlemek istediğiniz isimde bir resim zaten var."}';
                                    exit;
                                }

                                $update->setMetaValue($fileName.'.'.$extension);
                            }


                            $showCheck = 0;
                            if(isset($showcase)) {
                                $showCheck = 1;
                                $meta_key=$update->getMetaKey();
                                $images=Images::findFirst("meta_key="."'$meta_key'"." and content_id=".$update->getContentId()." and showcase=1");
                                if ($images){
                                    $images->setShowcase(0);
                                    $images->save();
                                }

                            }
                            $update->setShowcase($showCheck);


                            if($row != $update->getRow()){
                                $update->setRow($row);
                            }

                            $update->setUpdatedAt(self::getnow());
                            $update->update();
                            echo '{"status": "success"}';
                        } else {
                            echo '{"status": "failed", "message": "Dosya bulunamadı."}';
                        }

                    }
                }

            }
        }

    }

    public function removeAction() {
        $this->view->disable();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isGet()) {
                if ($this->request->isAjax()) {

                    $id = $this->request->getQuery('id');
                    $table = $this->request->getQuery('table');

                    $image = Images::findFirst($id);

                    @unlink(BASE_PATH.'/public/media/'.$image->getMetaKey().'/mini/100x120_'.$image->getMetaValue());
                    @unlink(BASE_PATH.'/public/media/'.$image->getMetaKey().'/mini/65x95_'.$image->getMetaValue());
                    @unlink(BASE_PATH.'/public/media/'.$image->getMetaKey().'/mini/50x60_'.$image->getMetaValue());

                    if (is_numeric($id)) {
                        $image = Images::findFirst($id);

                        if ($image) {
                            @unlink(BASE_PATH.'/public/media/'.$image->getMetaKey().'/'.$image->getMetaValue());

                            if ($image->delete()) {
                                echo '{"status": "success"}';
                            }else {
                                echo '{"status": "failed", "message": "Resim veri tabanından silinemedi."}';
                            }
                        }else {
                            echo '{"status": "failed", "message": "Veri tabanında kayıt bulunamadı."}';
                        }
                    }
                }
            }
        }

    }

    public function getFileName($id = false, $table = false) {
        if (is_numeric($id) && $table) {
            if ($table == 'category') {
                $table = 'cats';
            } else if ($table == 'theme_content/footer') {
                $table = 'themecontent';
            } else if ($table == 'theme_content/modal') {
                $table = 'themecontent';
            } else if ($table == 'theme_content/logo') {
                $table = 'themecontent';
            }
            $item = self::db($table)::findFirst($id);
            if ($item) {
                $rand = new Random();
                $rand = $rand->number(99999999);
                $name = $this->createSlug($item->getName());
                return $name."-".$rand;
            }
        }
    }

    public function createSlug($str, $delimiter = '-'){
        $unwanted_array = ['ś'=>'s', 'ą' => 'a', 'ć' => 'c', 'ç' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ź' => 'z', 'ż' => 'z', 'Ś'=>'s', 'Ą' => 'a', 'Ć' => 'c', 'Ç' => 'c', 'Ę' => 'e', 'Ł' => 'l', 'Ń' => 'n', 'Ó' => 'o', 'Ź' => 'z', 'Ż' => 'z'];
        $str = strtr( $str, $unwanted_array );
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }

}
