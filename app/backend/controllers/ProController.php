<?php
declare(strict_types=1);

namespace Yabasi\Backend\Controllers;


use PhpOffice\PhpSpreadsheet\Reader\Xlsx\Theme;
use Yabasi\Cats;
use Yabasi\Catsmenu;
use Yabasi\Images;
use Yabasi\Menu;
use Yabasi\Product;
use Yabasi\Themecontent;
use Yabasi\Themes;
use Yabasi\User;

class ProController extends ControllerBase
{

    public function initialize()
    {
        self::getName();
        self::getModul();
        self::isAuth();
        self::checkmodul('setting');
        $this->view->cevir = self::getTranslator();
        $this->view->user_id = self::getAuthId();
        $this->view->site_url = self::site_url();
        $this->view->page = 'setting';
        $this->view->subpage = 'themes';
        self::checkLicenceKey();
    }

    public function indexAction($id = false)
    {
        self::isAuthority("pro", "read");
        $this->view->type = 'update';
        $this->view->subpage = 'themes';
    }

    public function updateThemecontent($key = false, $value = false, $id = false){
        //Tablo Silme İşlemleri Yapılacak.
        self::isAuthority("pro", "read");
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{

        }if ($key) {
            $update = Themecontent:: findFirst('name="' . $key . '"' . "and theme_id=" . $id);
            if ($update) {
                $update->setThemeId($id);
                $update->setValue($value);
                $update->setUpdatedAt(self::getnow());
                $update->update();
            } else {
                $insert = new Themecontent();
                $insert->setThemeId($id);
                $insert->setName($key);
                $insert->setValue($value);
                $insert->setCreatedAt(self::getnow());
                $insert->setUpdatedAt(self::getnow());
                $insert->setStatus(1);
                $insert->save();
            }
        }

    }


    public function genelayarAction($id = false)
    {
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {

                $aktif_et = $this->request->getPost('aktif_et');
                $aktif = Themes::findFirst($id);
                $aktif->setStatus($aktif_et);
                $aktif->save();

                $this->updateThemecontent('urun_fiyat_gosterim_tipi', $this->request->getPost('urun_fiyat_gosterim_tipi'), $id);
                $this->updateThemecontent('marka_gosterim_tipi', $this->request->getPost('marka_gosterim_tipi'), $id);
                $this->updateThemecontent('vitrin_bir_satir_urun_adedi', $this->request->getPost('vitrin_bir_satir_urun_adedi'), $id);
                $this->updateThemecontent('kategori_detay_gosterim', $this->request->getPost('kategori_detay_gosterim'), $id);
                $this->updateThemecontent('marka_detay_gosterim', $this->request->getPost('marka_detay_gosterim'), $id);
                $this->updateThemecontent('kategori_breadcrumb_kullanim', $this->request->getPost('kategori_breadcrumb_kullanim'), $id);
                $this->updateThemecontent('siparis_asama_kdv_gosterim', $this->request->getPost('siparis_asama_kdv_gosterim'), $id);
                $this->updateThemecontent('stok_kod_gosterim', $this->request->getPost('stok_kod_gosterim'), $id);
                $this->updateThemecontent('kdv_haric_fiyat_gosterim', $this->request->getPost('kdv_haric_fiyat_gosterim'), $id);
                $this->updateThemecontent('en_dusuk_taksit_gosterim', $this->request->getPost('en_dusuk_taksit_gosterim'), $id);
                $this->updateThemecontent('urun_detay_urun_ozellikleri_gosterim', $this->request->getPost('urun_detay_urun_ozellikleri_gosterim'), $id);
                $this->updateThemecontent('paylasim_link_kullanimi', $this->request->getPost('paylasim_link_kullanimi'), $id);
                $this->updateThemecontent('anasayfa_height', $this->request->getPost('anasayfa_height'), $id);
                $this->updateThemecontent('diger_height', $this->request->getPost('diger_height'), $id);
            }
        }



        if (is_numeric($id)) {
            $themes = Themes::findFirst($id);
            if ($themes) {

                $this->view->type = 'pro';
                $this->view->subpage = 'genelayar';
                $this->view->id = $id;

                $this->view->themes = Themes::find();

                $this->view->themes = Themes::findFirst($id);
                $this->view->images = Images::find('content_id = ' . $id . ' and meta_key = "theme_content/logo" ORDER BY "row" ASC');
                $this->view->themes2 = Themes::findFirst($id);
                $this->view->images2 = Images::find('content_id = ' . $id . ' and meta_key = "theme_content/footer" ORDER BY "row" ASC');


                $this->view->urun_fiyat_gosterim_tipi = Themecontent::findFirst('name="urun_fiyat_gosterim_tipi" and theme_id=' . $id);
                $this->view->marka_gosterim_tipi = Themecontent::findFirst('name="marka_gosterim_tipi" and theme_id=' . $id);
                $this->view->vitrin_bir_satir_urun_adedi = Themecontent::findFirst('name="vitrin_bir_satir_urun_adedi" and theme_id=' . $id);

                $this->view->kategori_detay_gosterim = Themecontent::findFirst('name="kategori_detay_gosterim" and theme_id=' . $id);
                $this->view->marka_detay_gosterim = Themecontent::findFirst('name="marka_detay_gosterim" and theme_id=' . $id);
                $this->view->kategori_breadcrumb_kullanim = Themecontent::findFirst('name="kategori_breadcrumb_kullanim" and theme_id=' . $id);
                $this->view->siparis_asama_kdv_gosterim = Themecontent::findFirst('name="siparis_asama_kdv_gosterim" and theme_id=' . $id);

                $this->view->stok_kod_gosterim = Themecontent::findFirst('name="stok_kod_gosterim" and theme_id=' . $id);
                $this->view->kdv_haric_fiyat_gosterim = Themecontent::findFirst('name="kdv_haric_fiyat_gosterim" and theme_id=' . $id);
                $this->view->en_dusuk_taksit_gosterim = Themecontent::findFirst('name="en_dusuk_taksit_gosterim" and theme_id=' . $id);
                $this->view->urun_detay_urun_ozellikleri_gosterim = Themecontent::findFirst('name="urun_detay_urun_ozellikleri_gosterim" and theme_id=' . $id);
                $this->view->paylasim_link_kullanimi = Themecontent::findFirst('name="paylasim_link_kullanimi" and theme_id=' . $id);

                $this->view->anasayfa_height = Themecontent::findFirst('name="anasayfa_height" and theme_id=' . $id);
                $this->view->diger_height = Themecontent::findFirst('name="diger_height" and theme_id=' . $id);


            }
        }
    }

    public function renkAction($id = false)
    {
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {

                $aktif_et = $this->request->getPost('aktif_et');
                $aktif = Themes::findFirst($id);

                $aktif->setStatus($aktif_et);
                $aktif->save();

                $this->updateThemecontent('tema_rengi', $this->request->getPost('tema_rengi'), $id);
                $this->updateThemecontent('buton_rengi', $this->request->getPost('buton_rengi'), $id);
                $this->updateThemecontent('buton_yazi_rengi', $this->request->getPost('buton_yazi_rengi'), $id);
                $this->updateThemecontent('tema_buton_hover_rengi', $this->request->getPost('tema_buton_hover_rengi'), $id);
                $this->updateThemecontent('tema_yazi_rengi', $this->request->getPost('tema_yazi_rengi'), $id);
                $this->updateThemecontent('menu_cizgi_rengi', $this->request->getPost('menu_cizgi_rengi'), $id);
                $this->updateThemecontent('tema_buton_hover_yazi_rengi', $this->request->getPost('tema_buton_hover_yazi_rengi'), $id);
                $this->updateThemecontent('tema_buton_hover_kenarlik_rengi', $this->request->getPost('tema_buton_hover_kenarlik_rengi'), $id);

            }
        }


        if (is_numeric($id)) {
            $themes = Themes::findFirst($id);
            if ($themes) {
                $this->view->type = 'pro';
                $this->view->subpage = 'renk';
                $this->view->id = $id;
                $this->view->themes = Themes::findFirst();


                $this->view->tema_rengi = Themecontent::findFirst('name="tema_rengi" and theme_id=' . $id);
                $this->view->buton_rengi = Themecontent::findFirst('name="buton_rengi" and theme_id=' . $id);
                $this->view->buton_yazi_rengi = Themecontent::findFirst('name="buton_yazi_rengi" and theme_id=' . $id);
                $this->view->tema_buton_hover_rengi = Themecontent::findFirst('name="tema_buton_hover_rengi" and theme_id=' . $id);
                $this->view->tema_yazi_rengi = Themecontent::findFirst('name="tema_yazi_rengi" and theme_id=' . $id);
                $this->view->menu_cizgi_rengi = Themecontent::findFirst('name="menu_cizgi_rengi" and theme_id=' . $id);
                $this->view->tema_buton_hover_yazi_rengi = Themecontent::findFirst('name="tema_buton_hover_yazi_rengi" and theme_id=' . $id);
                $this->view->tema_buton_hover_kenarlik_rengi = Themecontent::findFirst('name="tema_buton_hover_kenarlik_rengi" and theme_id=' . $id);
            }
        }
    }

    public function topAction($id = false) {

        $themes = Themecontent::findFirst('name="top_metin" and theme_id='.$id);
        $cerez = Themecontent::findFirst('name="cerez" and theme_id='.$id);
        if ($themes) {
            $this->view->themes = $themes;
            $this->view->id = $id;
        }
        if ($cerez) {
            $this->view->cerez = $cerez;
            $this->view->id = $id;
        }

        $user = User::findFirst($this->getAuthId());
        if ($user->getGroupId() != 3){
            if ($this->request->isPost()) {
                $this->updateThemecontent('top_metin', $this->request->getPost('top_metin'), $id);
                $this->updateThemecontent('cerez', $this->request->getPost('cerez'), $id);
                return $this->response->redirect('backend/pro/top/'.$id);
            }
        }
    }

    public function footerAction($id = false)
    {
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {

                $aktif_et = $this->request->getPost('aktif_et');
                $aktif = Themes::findFirst($id);

                $aktif->setStatus($aktif_et);
                $aktif->save();

                $this->updateThemecontent('bulten_basligi', $this->request->getPost('bulten_basligi'), $id);
                $this->updateThemecontent('footer_manu', $this->request->getPost('footer_manu'), $id);
                $this->updateThemecontent('copyright_yazisi', $this->request->getPost('copyright_yazisi'), $id);
            }
        }




        if (is_numeric($id)) {
            $themes = Themes::findFirst($id);
            if ($themes) {
                $this->view->type = 'pro';
                $this->view->subpage = 'footer';
                $this->view->id = $id;
                $this->view->themes = Themes::findFirst();

                $this->view->bulten_basligi = Themecontent::findFirst('name="bulten_basligi" and theme_id=' . $id);
                $this->view->footer_manu = Themecontent::findFirst('name="footer_manu" and theme_id=' . $id);
                $this->view->copyright_yazisi = Themecontent::findFirst('name="copyright_yazisi" and theme_id=' . $id);
            }
        }


    }

    public function socialMediaAction($id = false)
    {
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                $aktif_et = $this->request->getPost('aktif_et');
                $aktif = Themes::findFirst($id);

                $aktif->setStatus($aktif_et);
                $aktif->save();

                if ($this->request->isPost()) {
                    $this->updateThemecontent('sosyal_aglar_basligi', $this->request->getPost("sosyal_aglar_basligi"), $id);
                    $this->updateThemecontent('facebook_adres', $this->request->getPost("facebook_adres"), $id);
                    $this->updateThemecontent('twitter_adres', $this->request->getPost("twitter_adres"), $id);
                    $this->updateThemecontent('pinterest_adres', $this->request->getPost("pinterest_adres"), $id);
                    $this->updateThemecontent('youtube_adres', $this->request->getPost("youtube_adres"), $id);
                    $this->updateThemecontent('instagram_adres', $this->request->getPost("instagram_adres"), $id);
                    $this->updateThemecontent('linkedin_adres', $this->request->getPost("linkedin_adres"), $id);
                    $this->updateThemecontent('whatsapp_numara', $this->request->getPost("whatsapp_numara"), $id);
                    $this->updateThemecontent('hemen_ara', $this->request->getPost("hemen_ara"), $id);
                }

            }
        }


        if (is_numeric($id)) {
            $themes = Themes::findFirst($id);
            if ($themes) {

                $this->view->id = $id;
                $this->view->type = 'pro';
                $this->view->subpage = 'socialMedia';
                $this->view->themes = Themes::findFirst();


                $this->view->sosyal_aglar_basligi = Themecontent::findFirst('name="sosyal_aglar_basligi" and theme_id=' . $id);
                $this->view->facebook_adres = Themecontent::findFirst('name="facebook_adres" and theme_id=' . $id);
                $this->view->twitter_adres = Themecontent::findFirst('name="twitter_adres" and theme_id=' . $id);
                $this->view->pinterest_adres = Themecontent::findFirst('name="pinterest_adres" and theme_id=' . $id);
                $this->view->youtube_adres = Themecontent::findFirst('name="youtube_adres" and theme_id=' . $id);
                $this->view->instagram_adres = Themecontent::findFirst('name="instagram_adres" and theme_id=' . $id);
                $this->view->linkedin_adres = Themecontent::findFirst('name="linkedin_adres" and theme_id=' . $id);
                $this->view->whatsapp_numara = Themecontent::findFirst('name="whatsapp_numara" and theme_id=' . $id);
                $this->view->hemen_ara = Themecontent::findFirst('name="hemen_ara" and theme_id=' . $id);


            }
        }
    }

    public function mansetAction($id = false)
    {
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {

                $aktif_et = $this->request->getPost('aktif_et');
                $aktif = Themes::findFirst($id);

                $aktif->setStatus($aktif_et);
                $aktif->save();

                $this->updateThemecontent('gecis_tipi', $this->request->getPost('gecis_tipi'), $id);
                $this->updateThemecontent('resim_degisme_suresi', $this->request->getPost('resim_degisme_suresi'), $id);;
                $this->updateThemecontent('ileri_geri_button_gosterim', $this->request->getPost('ileri_geri_button_gosterim'), $id);
                $this->updateThemecontent('minislider_cerceve_rengi', $this->request->getPost('minislider_cerceve_rengi'), $id);

            }
        }


        if (is_numeric($id)) {
            $themes = Themes::findFirst($id);
            if ($themes) {

                $this->view->type = 'pro';
                $this->view->subpage = 'slider';
                $this->view->id = $id;
                $this->view->themes = Themes::findFirst();

                $this->view->gecis_tipi = Themecontent::findFirst('name="gecis_tipi" and theme_id=' . $id);
                $this->view->resim_degisme_suresi = Themecontent::findFirst('name="resim_degisme_suresi" and theme_id=' . $id);
                $this->view->ileri_geri_button_gosterim = Themecontent::findFirst('name="ileri_geri_button_gosterim" and theme_id=' . $id);
                $this->view->minislider_cerceve_rengi = Themecontent::findFirst('name="minislider_cerceve_rengi" and theme_id=' . $id);
            }
        }

    }

    public function modalAction($id = false)
    {
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {

                $aktif_et = $this->request->getPost('aktif_et');
                $aktif = Themes::findFirst($id);

                $aktif->setStatus($aktif_et);
                $aktif->save();

                $this->updateThemecontent('yonlendirme_url', $this->request->getPost('yonlendirme_url'), $id);
            }
        }



            $themes = Themes::findFirst($id);
            if ($themes) {
                $this->view->type = 'pro';
                $this->view->subpage = 'modal';
                $this->view->id = $id;
                $this->view->themes = Themes::findFirst($id);


                $this->view->themes5 = Themes::findFirst($id);
                $this->view->images5 = Images::find('content_id = ' . $id . ' and meta_key = "theme_content/modal" ORDER BY "row" ASC');
                $this->view->yonlendirme_url = Themecontent::findFirst('name="yonlendirme_url" and theme_id=' . $id);
            }



    }

    public function menuAction($id = false) {
        if (is_numeric($id)) {

            $this->view->catlist = $this->listMenu(0);

            $themes = Themes::findFirst($id);
            if ($themes) {
                $this->view->type = 'pro';
                $this->view->subpage = 'menu1';
                $this->view->id = $id;
                $this->view->themes = Themes::findFirst($id);

            }
        }

        $cats = Cats::find('status=1 and top_id=0');
        if (count($cats) > 0) {
            $this->view->cats = $cats;
        }

        $menu = Menu::find(array('conditions'=>'which = 1 and status = 1', 'order' => 'row_number ASC'));
        if (count($menu) > 0) {
            $this->view->menuHeader = $menu;
        }

        $menu2 = Menu::find(array('conditions'=>'which = 2 and status = 1', 'order' => 'row_number ASC'));
        if (count($menu2) > 0) {
            $this->view->menuFooter = $menu2;
        }
    }

    public function faturaAction($id = false) {

        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else {
            // KODLAR

        }

    }

    public function countSubCat($id = false) {
        if (is_numeric($id)) {
            $cats = Cats::find('top_id='.$id);
            return count($cats);
        }
    }

    public function listMenu($id = 0) {
        if (is_numeric($id)) {
            $cats = Cats::find('top_id='.$id);
            if ($cats) {
                $items = '';
                foreach ($cats as $item) {
                    $items .= '
                    <li class="navi-item mb-2 tasi menu_'.$item->getId().'" id="row_'.$item->getId().'" data-title="'.$item->getName().'" data-id="'.$item->getId().'">
                        <a href="javascript:;" class="navi-link py-4 active">
                            <span class="navi-icon mr-2"><i class="icon-xl fas fa-arrows-alt fixcolor"></i></span>
                            <span class="navi-text font-size-lg sira" data-name="'.$item->getName().'" data-id="'.$item->getId().'">'.$item->getName().'</span>
                            <i class="icon-md fas fa-times text-danger removeMenu dn" data-id="'.$item->getId().'"></i>
                        </a>
                    </li>';
                    if ($this->countSubCat($item->getId()) > 0) {
                        $items .= '<ul>'.self::listMenu($item->getId()).'</ul>';
                    }
                }
                return $items;
            }
        }
    }



    public function menusaveAction($theme_id = false , $which = false) {
        $this->view->disable();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isPost()) {
                if ($this->request->isAjax()) {

                    $rows = $this->request->getPost('row');
                    $counter = 0;
                    foreach ($rows as $row) {
                        $update = Menu::findFirst('cats_id = ' . $rows[$counter] . ' and theme_id = ' . $theme_id . ' and which = ' . $which);

                        if ($update) {
                            $update->setRowNumber($counter +1);
                            $update->setUpdatedAt(self::getnow());
                            $update->update();
                            echo "ok";
                        } else {
                            $new = new Menu();
                            $new->setCatsId($rows[$counter]);
                            $new->setThemeId($theme_id);
                            $new->setWhich($which);
                            $new->setRowNumber($counter +1);
                            $new->setCreatedAt(self::getnow());
                            $new->setUpdatedAt(self::getnow());
                            $new->setStatus(1);
                            $new->save();
                            echo "ok";
                        }
                        $counter++;
                    }
                    echo "ok";
                }

            }
        }

    }

    public function removemenuAction() {
        $this->view->disable();
        $user=User::findFirst($this->getAuthId());
        if ($user->getGroupId()==3){

        }else{
            if ($this->request->isAjax()) {
                if ($this->request->isPost()) {
                    $id = $this->request->getPost('id');
                    if (is_numeric($id)) {
                        $menu = Menu::findFirst('id='.$id);
                        if ($menu) {
                            $menu->delete();
                            echo 'ok';
                        }
                    }
                }
            }
        }

    }
}
