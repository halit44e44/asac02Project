<div class="card card-custom mb-5">
    <div class="card-header flex-wrap border-0">
        <div class="card-title">
            <h3 class="card-label">Modüller
                <span class="d-block text-muted pt-2 font-size-sm">Kullanmak istediğiniz modülleri aktif edin, hemen kullanmaya başlayın.</span>
            </h3>
        </div>


</div>
</div>
<div class="row">
    {% if modul is defined %}
        {% for modul in modul %}
            <div class="col-xl-4" id="row_{{ modul.id }}">
                <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ url('assets/theme7/media/svg/shapes/abstract-2.svg') }});">
                    <div class="card-body">
                        <a href="javascript:;" class="card-title font-weight-bold text-muted text-hover-primary font-size-h5">{{ modul.name }}</a>
                        <div class="font-weight-bold text-success mt-9 mb-5">{% if modul.price==0 %} Sorunuz {% else%}{{ modul.price }} ₺ {% endif %}</div>
                        <p class="text-dark-75 font-weight-normal font-size-lg m-0">{{ modul.content }}</p>
                        <br>
                        <button href="javascript:;" onclick="showModul(this)" data-id="{{ modul.id }}" class="btn {% if modul.status is "1" %}btn-primary{% elseif modul.status is "2" %}btn-warning{% else %}btn-success{% endif%} font-weight-bold py-2 px-6" {%if modul is defined%}{% if modul.status is 1 or modul.status  is 2 %} disabled="disabled" {% endif %}{% endif %}>{%if modul is defined%}{%if modul.status=="1"%}Aktif{% elseif modul.status is 2 %}Sipariş Verildi{% else %}Pasif{% endif %}{% endif %}</button>
                    </div>
                </div>
            </div>
        {% endfor %}
    {% endif %}
</div>

<div class="modal fade modulModal" tabindex="-1" role="dialog" aria-labelledby="modulModaLabel" aria-hidden="true">
    <form method="post" class="modulPost">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modulModaLabel">Modül Detayı</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-secondary sozlesme_alert dn" role="alert">Lütfen sözleşmeyi onaylayınız!</div>
                        <table class="table table-borderless">
                            <tbody>

                            </tbody>
                        </table>
                        <div class="form-group">
                            <label class="checkbox">
                                <input type="checkbox" name="sozlesme" class="sozlesme">
                                <span class="mr-5"></span>Sözleşmeyi kabul ediyorum</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Kapat</button>
                        <button type="button" class="btn btn-primary" onclick="submitModulForm(this)">Kaydet</button>
                    </div>
                </div>
            </div>
      </form>
</div>

<script>
function showModul(el) {
    $('.sozlesme_alert').addClass('dn');
    const id = $(el).data('id');
    $.get(base_url+'modul/get/'+id, function (data) {
        $('.modulModal table tbody').html(data);
        $('.modulModal').modal('show');
    });
}


function submitModulForm(el) {
    const id = $('.id').val();
    if ($('.sozlesme').is(':checked') === false) {
        $('.sozlesme_alert').removeClass('dn');
        return false;
    } else {
        $('.sozlesme_alert').addClass('dn');
    }

    if (id) {
        $.get(base_url+'modul/buy/'+id, function (data) {
            if (data === 'ok') {
                $('#row_'+id+' .card .card-body .btn').html('Sipariş Verildi').attr('disabled', 'true').removeClass('btn-success').addClass('btn-warning');
                $('.modulModal').modal('hide');
            }
        });
    }
}
</script>

