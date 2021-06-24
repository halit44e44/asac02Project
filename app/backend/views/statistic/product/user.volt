<div class="card card-custom gutter-b mt-10">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                En çok sipariş veren kullanıcılar
            </h3>
        </div>
    </div>
    <div class="form-group row">
        {% for statisticpro in statisticpro %}
            <div class="col-xl-4">
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Wrapper-->
                        <div class="d-flex justify-content-between flex-column h-100">
                            <!--begin::Container-->
                            <div class="h-100">
                                <!--begin::Header-->
                                <div class="d-flex flex-column flex-center">
                                    <?php
                                    $image_name = 'media/resimyok.png';
                                    $image = \Yabasi\Images::findFirst('content_id='.$statisticpro->getProId().' and meta_key="product" and status=1');
                                    if($image) {
                                    $image_name = 'media/product/'.$image->meta_value;
                                    $this->view->image=$image_name;
                                    }
                                    ?>
                                    <?php
                                    $pro_name = '';
                                    $product = \Yabasi\Product::findFirst($statisticpro->getProId());
                                    if($product) {
                                    $pro_name = $product->name;

                                    }
                                    ?>
                                    <?php
                                    $user_name = '';
                                    $user = \Yabasi\User::findFirst($statisticpro->getUserId());
                                    if($user) {
                                    $user_name= $user->name;
                                    $email= $user->email;
                                    }
                                    ?>
                                    <div class="bgi-no-repeat bgi-size-cover rounded min-h-300px w-100" style="background-image: url({{ image_name }})"></div>
                                    <!--end::Image-->
                                    <!--begin::Title-->
                                    <a href="#" class="card-title font-weight-bolder text-dark-75 text-hover-primary font-size-h4 m-0 pt-7 pb-1">{{ pro_name }}</a>
                                    <!--end::Title-->
                                    <!--begin::Text-->

                                    <!--end::Text-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="pt-1">
                                    <!--begin::Item-->

                                    <div class="d-flex align-items-center pb-9">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-45 symbol-light mr-4">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-2x svg-icon-dark-50">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
                                                            <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
                                                            <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
                                                            <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->

                                        <div class="d-flex flex-column flex-grow-1">
                                            <a href="{{ url('backend/user/profile/vizor/' ~ statisticpro.userId) }}" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">{{ user_name }}</a>
                                            <span class="text-muted font-weight-bold">{{ email }}</span>
                                        </div>
                                        <!--end::Text-->
                                        <!--begin::label-->
                                        <span class="font-weight-bolder label label-xl label-light-success label-inline px-3 py-5 min-w-45px">{{ statisticpro.count }}</span>
                                        <!--end::label-->
                                    </div>



                                </div>

                            </div>


                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Nav Panel Widget 3-->
            </div>
        {% endfor %}
    </div>
</div>