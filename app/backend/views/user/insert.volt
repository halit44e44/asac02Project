<div class="alert alert-secondary rounded-0 dn" role="alert"></div>

<form class="form" id="userForm" method="post">
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Yeni Kullanıcı  Ekle</h3>
        </div>

        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Email:</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                    <i class="flaticon-multimedia" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="email"  name="email" id="email" class="form-control" placeholder="Email Adresiniz" />
                    </div>
                </div>

                <div class="col-lg-6">
                    <label>Şifre:</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                    <i class="fas fa-key" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="password"  name="password" id="password" class="form-control" placeholder="Şifre" />
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Kullanıcı Grup:</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                    <i class="fas fa-users" aria-hidden="true"></i>
                            </span>
                        </div>
                        <select class="form-control" name="group_id">
                            {% if userGroups is defined %}
                                {% for userGroup in userGroups %}
                                    <option value="{{ userGroup.id }}">{{ userGroup.name }}</option>
                                {% endfor %}
                            {% endif %}
                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <label>Ad Soyad:</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" id="name" name="name" maxlength="100" minlength="4" class="form-control" placeholder="Adınızı Soyadınız">
                    </div>

                </div>

            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Tc Kimlik:</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                    <i class="flaticon-multimedia" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" id="id_no" name="id_no"  class="form-control " placeholder="Tc Kimlik">
                    </div>

                </div>
                <div class="col-lg-6">
                    <label>Doğum Tarihi:</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                    <i class="fas fa-birthday-cake" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" id="birth_date" name="birth_date"  class="form-control" placeholder="Doğum Tarihi" >
                    </div>

                </div>

            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Telefon:</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                    <i class="fas fa-phone-alt" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" id="phone" name="phone"  class="form-control " placeholder="Telefon">
                    </div>


                </div>
                <div class="col-lg-6">
                    <label>Doğum Tarihi:</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                    <i class="fas fa-transgender" aria-hidden="true"></i>
                            </span>
                        </div>
                        <select class="form-control" name="gender">
                            <option value="1">Erkek</option>
                            <option value="2">Kadın</option>
                            <option value="3">Belirtmek İstemiyorum</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <a href="{{ url('backend/user') }}" class="btn btn-secondary float-left">Vazgeç</a>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#userForm').validate({
            rules: {
                email: "required",
                password: "required",
                name: "required"
            },
            messages: {
                email: "Bu alan zorunludur!",
                password: "Bu alan zorunludur!",
                name: "Bu alan zorunludur!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#userForm').serialize();

                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/user/insert/") }}',
                    data: data,
                    success: function (response) {

                        const obj = jQuery.parseJSON(response);

                        if (obj.status === 'ok') {
                            $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                            goTop();
                        } else if(obj.status === 'thereis') {
                            $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-danger').html('Yazmış olduğunuz email adresi başka bir kullanıcıya aittir!');
                            goTop();
                        } else {
                            $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                            goTop();
                        }
                    }
                });
            }
        });
    });
</script>