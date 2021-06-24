
<form class="form"  id="kt_form_1" method="post">
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
                        <input type="email" value="{{ user.email }}" name="email" id="email" class="form-control" placeholder="Email Adresiniz" required />
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
                        <input type="text" value="{{ user.password }}" name="password" id="password" class="form-control" placeholder="Şifre" required />

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
                        <select class="form-control select2" id="kt_select2_2" name="group_id">
                            {% if userGroups is defined %}
                                {% for userGroup in userGroups %}

                                    <option value="{{ userGroup.id }}" {%if( user.group_id== userGroup.id ) %} selected {%endif%}> {{ userGroup.name }}</option>


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
                        <input type="text" id="name" name="name" value="{{ user.name }}"  class="form-control" placeholder="Adınızı Soyadınız" required="">

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
                        <input type="text" id="id_no" name="id_no"  value="{{ user.id_no }}" class="form-control " placeholder="Tc Kimlik" required>

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
                        <input type="text" id="birth_date" name="birth_date" value="{{ user.birth_date }}" class="form-control" placeholder="Doğum Tarihi" >

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
                        <input type="text" id="phone" name="phone"  class="form-control " value="{{ user.phone }}" placeholder="Telefon" required>

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
                        <select class="form-control select2" id="kt_select2_1" name="gender">


                            <option value="1" {%if( user.gender=="1" ) %} selected {%endif%}>Erkek</option>
                            <option value="2" {%if( user.gender=="2" ) %} selected {%endif%}>Kadın</option>
                            <option value="3"{%if( user.gender=="3" ) %} selected {%endif%}>Belirtmek İstemiyorum</option>
                        </select>
                    </div>

                </div>


            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" name="sumbit"  id="sumbit"  class="btn btn-primary mr-2" >Kaydet</button>
                        <button type="reset" class="btn btn-secondary">Vazgeç</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</form>


