<div class="card card-custom" xmlns="http://www.w3.org/1999/html">
    <!--begin::Header-->
    <div class="card-header card-header-tabs-line">
        <ul class="nav nav-dark nav-bold nav-tabs nav-tabs-line" data-remember-tab="tab_id" role="tablist">
            <li class="nav-item">
                <a class="nav-link"href="{{ url('backend/pro/genelayar/' ~ id)}}" >Genel Ayarlar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active renk_ayarlari" href="{{ url('backend/pro/renk/' ~ id)}}">Renk Ayarları</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/top/' ~ id) }}">İçerik</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/footer/' ~ id) }}">Footer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/socialmedia/' ~ id) }}">Sosyal Ağlar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/manset/' ~ id) }}">Manşet Ayarları</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/modal/' ~ id) }}">Modal Ayarları</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/menu/' ~ id) }}">Menü Ayarları</a>
            </li>
        </ul>
    </div>

    <div class="alert alert-secondary rounded-0 dn" role="alert"></div>

    <div class="card-body">

            <div class="tab-pane" id="renk_ayarlari" role="tabpanel">
                <form id="renkForm" method="post">
                    <input type="hidden" name="param" value="renk_ayarlari"/>
                    <input type="hidden" name="id" value="{% if id is defined %}{{ id }}{% endif %}"/>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right"> Tema Rengi</label>
                        <div class="input-group-addon">
                            <input name="tema_rengi" type="text" id="hex" maxlength="7" value="{% if tema_rengi is defined %}{{ tema_rengi.value }}" style="background: {{ tema_rengi.value }}; border: 1px solid {{ tema_rengi.value }}; font-size: 12px; padding: 5px 10px;"{% endif %}/>
                            <input type="color" id="color"/>
                        </div>
                        <div style="position: relative; left: 10px;">
                            <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                                    data-content="<img src='public/media/theme_content/renk/tema_rengi.png' width='700' />">?
                            </button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right"> Tema Buton Hover Rengi</label>
                        <div class="input-group-addon">
                            <input name="tema_buton_hover_rengi" type="hex" id="hex7" maxlength="7"
                                   value="{% if tema_buton_hover_rengi is defined %}{{ tema_buton_hover_rengi.value }}" style="background: {{ tema_buton_hover_rengi.value }}; border: 1px solid {{ tema_buton_hover_rengi.value }}; font-size: 12px; padding: 5px 10px;"{% endif %}/>
                            <input type="color" id="color7"/>
                        </div>
                        <div style="position: relative; left: 10px;">
                            <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                                    data-content="<img src='public/media/theme_content/renk/buton_hover.png' width='300' />">?
                            </button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right"> Tema Buton Hover Kenarlık Rengi</label>
                        <div class="input-group-addon">
                            <input name="tema_buton_hover_kenarlik_rengi" type="hex" id="hex9" maxlength="7"
                                   value="{% if tema_buton_hover_kenarlik_rengi is defined %}{% if tema_buton_hover_kenarlik_rengi.status == "1" %}{{ tema_buton_hover_kenarlik_rengi.value }}{% endif %}" style="background: {{ tema_buton_hover_kenarlik_rengi.value }}; border: 1px solid {{ tema_buton_hover_kenarlik_rengi.value }}; font-size: 12px; padding: 5px 10px;"{% endif %}/>
                            <input type="color" id="color9"/>
                        </div>
                        <div style="position: relative; left: 10px;">
                            <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                                    data-content="<img src='public/media/theme_content/renk/buton_hover_kenarlik.png' width='300' />">?
                            </button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right"> Tema Buton Hover Yazi Rengi</label>
                        <div class="input-group-addon">
                            <input name="tema_buton_hover_yazi_rengi" type="hex" id="hex8" maxlength="7"
                                   value="{% if tema_buton_hover_yazi_rengi is defined %}{% if tema_buton_hover_yazi_rengi.status == "1" %}{{ tema_buton_hover_yazi_rengi.value }}{% endif %}" style="background: {{ tema_buton_hover_yazi_rengi.value }}; border: 1px solid {{ tema_buton_hover_yazi_rengi.value }}; font-size: 12px; padding: 5px 10px;"{% endif %}/>
                            <input type="color" id="color8"/>
                        </div>
                        <div style="position: relative; left: 10px;">
                            <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                                    data-content="<img src='public/media/theme_content/renk/buton_hover_yazi.png' width='300' />">?
                            </button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right"> Tema Yazı Rengi</label>
                        <div class="input-group-addon">
                            <input name="tema_yazi_rengi" type="text" id="hex5" maxlength="7"
                                   value="{% if tema_yazi_rengi is defined %}{% if tema_yazi_rengi.status == "1" %}{{ tema_yazi_rengi.value }}{% endif %}" style="background: {{ tema_yazi_rengi.value }}; border: 1px solid {{ tema_yazi_rengi.value }}; font-size: 12px; padding: 5px 10px;"{% endif %}/>
                            <input type="color" id="color5"/>
                        </div>
                        <div style="position: relative; left: 10px;">
                            <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                                    data-content="<img src='public/media/theme_content/renk/tema_rengi.png' width='700' />">?
                            </button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right"> Menü Çizgi Rengi</label>
                        <div class="input-group-addon">
                            <input name="menu_cizgi_rengi" type="text" id="hex6" maxlength="7"
                                   value="{% if menu_cizgi_rengi is defined %}{% if menu_cizgi_rengi.status == "1" %}{{ menu_cizgi_rengi.value }}{% endif %}" style="background: {{ menu_cizgi_rengi.value }}; border: 1px solid {{ menu_cizgi_rengi.value }}; font-size: 12px; padding: 5px 10px;"{% endif %}/>
                            <input type="color" id="color6"/>
                        </div>
                        <div style="position: relative; left: 10px;">
                            <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                                    data-content="<img src='public/media/theme_content/renk/menu_cizgi.png' width='300' />">?
                            </button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right"> Buton Rengi</label>
                        <div class="input-group-addon">
                            <input name="buton_rengi" type="text" id="hex2" maxlength="7"
                                   value="{% if buton_rengi is defined %}{% if buton_rengi.status == "1" %}{{ buton_rengi.value }}{% endif %}" style="background: {{ buton_rengi.value }}; border: 1px solid {{ buton_rengi.value }}; font-size: 12px; padding: 5px 10px;"{% endif %}/>
                            <input type="color" id="color2"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right"> Buton Yazı Rengi</label>
                        <div class="input-group-addon">
                            <input name="buton_yazi_rengi" type="hex" id="hex3" maxlength="7"
                                   value="{% if buton_yazi_rengi is defined %}{% if buton_yazi_rengi.status == "1" %}{{ buton_yazi_rengi.value }}{% endif %}" style="background: {{ buton_yazi_rengi.value }}; border: 1px solid {{ buton_yazi_rengi.value }}; font-size: 12px; padding: 5px 10px;"{% endif %}/>
                            <input type="color" id="color3"/>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-6 text-left">
                            <input type="button" onclick="window.location.href='{{ url('backend/setting/themes') }}'" class="btn btn-secondary btn-sm" value="Geri Dön">
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Sadece Kaydet</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>

</div>
<script>

    function defaults() {

        var tema_rengi = "#4c4c4c";
        var tema_buton_hover = "#ffffff";
        var tema_buton_hover_kenarlik = "#636363";
        var tema_buton_hover_yazi = "#636363";
        var tema_yazi_rengi = "#ffffff";
        var menu_cizgi_rengi = "#636363";
        var buton_rengi = "#4d4d4d";
        var buton_yazi_rengi = "#dfdddd";

        $('#hex').val(tema_rengi).css('background', tema_rengi).css('border', '1px solid '+tema_rengi);
        $('#hex7').val(tema_buton_hover).css('background', tema_buton_hover).css('border', '1px solid '+tema_buton_hover);
        $('#hex9').val(tema_buton_hover_kenarlik).css('background', tema_buton_hover_kenarlik).css('border', '1px solid '+tema_buton_hover_kenarlik);
        $('#hex8').val(tema_buton_hover_yazi).css('background', tema_buton_hover_yazi).css('border', '1px solid '+tema_buton_hover_yazi);
        $('#hex5').val(tema_yazi_rengi).css('background', tema_yazi_rengi).css('border', '1px solid '+tema_yazi_rengi);
        $('#hex6').val(menu_cizgi_rengi).css('background', menu_cizgi_rengi).css('border', '1px solid '+menu_cizgi_rengi);
        $('#hex2').val(buton_rengi).css('background', buton_rengi).css('border', '1px solid '+buton_rengi);
        $('#hex3').val(buton_yazi_rengi).css('background', buton_yazi_rengi).css('border', '1px solid '+buton_yazi_rengi);

    }

    let colorInput = document.querySelector('#color');
    let hexInput = document.querySelector('#hex');
    let color2Input = document.querySelector('#color2');
    let hex2Input = document.querySelector('#hex2');
    let color3Input = document.querySelector('#color3');
    let hex3Input = document.querySelector('#hex3');
    let color5Input = document.querySelector('#color5');
    let hex5Input = document.querySelector('#hex5');
    let color6Input = document.querySelector('#color6');
    let hex6Input = document.querySelector('#hex6');
    let color7Input = document.querySelector('#color7');
    let hex7Input = document.querySelector('#hex7');
    let color8Input = document.querySelector('#color8');
    let hex8Input = document.querySelector('#hex8');
    let color9Input = document.querySelector('#color9');
    let hex9Input = document.querySelector('#hex9');

    colorInput.addEventListener('input', () => {
        let color = colorInput.value;
        hexInput.value = color;
        //document.body.style.backgroundColor = color;
    });
    color2Input.addEventListener('input', () => {
        let color2 = color2Input.value;
        hex2Input.value = color2;
    });
    color3Input.addEventListener('input', () => {
        let color3 = color3Input.value;
        hex3Input.value = color3;
    });
    color5Input.addEventListener('input', () => {
        let color5 = color5Input.value;
        hex5Input.value = color5;
    });
    color6Input.addEventListener('input', () => {
        let color6 = color6Input.value;
        hex6Input.value = color6;
    });
    color7Input.addEventListener('input', () => {
        let color7 = color7Input.value;
        hex7Input.value = color7;
    });
    color8Input.addEventListener('input', () => {
        let color8 = color8Input.value;
        hex8Input.value = color8;
    });
    color9Input.addEventListener('input', () => {
        let color9 = color9Input.value;
        hex9Input.value = color9;
    });

</script>