<?php

namespace Yabasi\Frontend\Controllers;

use Phalcon\Mvc\Model;
use Yabasi\Images;
use Yabasi\Themecontent;
use Yabasi\User;


class Themes extends Model
{
    //SOSYAL MEDYA BAŞLAR
    public static function socialmedia($theme_id)
    {
        if (is_numeric($theme_id)) {
            $themes = Themecontent::findFirst('name="sosyal_aglar_basligi" and theme_id=' . $theme_id);
            if ($themes) {
                return $themes->getValue();
            } else {
                return null;
            }
        }
    }

    public static function socialmediaFace($theme_id)
    {
        if (is_numeric($theme_id)) {
            $themes_face = Themecontent::findFirst('name="facebook_adres" and theme_id=' . $theme_id);
            if ($themes_face) {
                return $themes_face->getValue();
            } else {
                return null;
            }
        }
    }

    public static function socialmediaTwiter($theme_id)
    {
        if (is_numeric($theme_id)) {
            $themes_twiter = Themecontent::findFirst('name="twitter_adres" and theme_id=' . $theme_id);
            if ($themes_twiter) {
                return $themes_twiter->getValue();
            } else {
                return null;
            }
        }
    }

    public static function socialmediaInstagram($theme_id)
    {
        if (is_numeric($theme_id)) {
            $themes_instagram = Themecontent::findFirst('name="instagram_adres" and theme_id=' . $theme_id);
            if ($themes_instagram) {
                return $themes_instagram->getValue();
            } else {
                return null;
            }
        }
    }

    public static function socialmediaYoutube($theme_id)
    {
        if (is_numeric($theme_id)) {
            $themes_youtube = Themecontent::findFirst('name="youtube_adres" and theme_id=' . $theme_id);
            if ($themes_youtube) {
                return $themes_youtube->getValue();
            } else {
                return null;
            }
        }
    }

    public static function socialmediaPinterest($theme_id)
    {
        if (is_numeric($theme_id)) {
            $themes_pinterest = Themecontent::findFirst('name="pinterest_adres" and theme_id=' . $theme_id);
            if ($themes_pinterest) {
                return $themes_pinterest->getValue();
            } else {
                return null;
            }
        }
    }

    public static function socialmediaLinkedin($theme_id)
    {
        if (is_numeric($theme_id)) {
            $themes_pinterest = Themecontent::findFirst('name="linkedin_adres" and theme_id=' . $theme_id);
            if ($themes_pinterest) {
                return $themes_pinterest->getValue();
            } else {
                return null;
            }
        }
    }

    public static function socialmediaWhatsapp($theme_id)
    {
        if (is_numeric($theme_id)) {
            $themes_pinterest = Themecontent::findFirst('name="whatsapp_numara" and theme_id=' . $theme_id);
            if ($themes_pinterest) {
                return $themes_pinterest->getValue();
            } else {
                return null;
            }
        }
    }

    public static function socialmediaHemenara($theme_id)
    {
        if (is_numeric($theme_id)) {
            $themes_pinterest = Themecontent::findFirst('name="hemen_ara" and theme_id=' . $theme_id);
            if ($themes_pinterest) {
                return $themes_pinterest->getValue();
            } else {
                return null;
            }
        }
    }


    //FOOTER BAŞLAR
    public static function footerBultenBasligi($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="bulten_basligi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function footerCopyright($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="copyright_yazisi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function footerMenu($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="footer_manu" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    //SLİDER BAŞLAR
    public static function sliderGecisTipi($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="gecis_tipi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function sliderResimDegisme($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="resim_degisme_suresi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function sliderIleriGeriButon($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="ileri_geri_button_gosterim" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function sliderCerceveRengi($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="minislider_cerceve_rengi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    //RENK AYARLARI BAŞLAR
    public static function renkTema($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="tema_rengi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function renkTemaYazi($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="tema_yazi_rengi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function setheight($theme_id, $height) {
        if (is_numeric($theme_id) && $height) {
            $theme = Themecontent::findFirst('name="anasayfa_height" and theme_id=' . $theme_id);
            $returned = '250px';
            if ($theme) {
                $height = (int) $height;
                (int) $value = substr($theme->getValue(), 0, -2);
                $returned = ($value +  $height);
            }
            return $returned."px";
        }
    }

    public static function renkButton($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="buton_rengi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function renkButtonYazi($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="buton_yazi_rengi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function renkMenuCizgi($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="menu_cizgi_rengi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function renkMenuHover($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="tema_buton_hover_rengi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function renkMenuHoverKenar($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="tema_buton_hover_kenarlik_rengi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    public static function renkMenuHoverYazi($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="tema_buton_hover_yazi_rengi" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

    //GENEL AYAR BAŞLAR
    public static function genelayarLogo($theme_id)
    {
        if (is_numeric($theme_id)) {
            $images = Images::findFirst('meta_key="theme_content/logo" and content_id=' . $theme_id);
            if ($images) {
                return $images->getMetaValue();
            } else {
                return null;
            }
        }
    }

    //MODAL AYARLARI BAŞLAR
    public static function modalLogo($theme_id)
    {
        if (is_numeric($theme_id)) {
            $images = Images::findFirst('meta_key="theme_content/modal" and content_id=' . $theme_id);
            if ($images) {
                return $images->getMetaValue();
            } else {
                return null;
            }
        }
    }
    public static function modalUrl($theme_id)
    {
        if (is_numeric($theme_id)) {
            $theme = Themecontent::findFirst('name="yonlendirme_url" and theme_id=' . $theme_id);
            if ($theme) {
                return $theme->getValue();
            } else {
                return null;
            }
        }
    }

}