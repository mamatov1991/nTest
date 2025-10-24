@extends('user.layout')

@section('main')
<div class="col-lg-9">
                            <!-- Start Enrole Course  -->
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                                <div class="content">

                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">To‘lovlar tarixi</h4>
                                    </div>

                                    <div class="advance-tab-button mb--30">
                                        <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="myTab-4" role="tablist">
                                            <li role="presentation">
                                                <a href="#" class="tab-button active" id="home-tab-4" data-bs-toggle="tab" data-bs-target="#home-4" role="tab" aria-controls="home-4" aria-selected="true">
                                                    <span class="title">Mening to‘lovlarim</span>
                                                </a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#" class="tab-button" id="profile-tab-4" data-bs-toggle="tab" data-bs-target="#profile-4" role="tab" aria-controls="profile-4" aria-selected="false">
                                                    <span class="title">Narxlar</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="home-4" role="tabpanel" aria-labelledby="home-tab-4">
                                            <div class="row g-5 mb--30">
                                                <div class="rbt-dashboard-table table-responsive mobile-table-750">
                                                    @php
                                                    $tarifreja=0;
                                                    foreach($my_tariffs as $tariff){
                                                    if($tariff['is_active'] == true){
                                                        $tarifreja=1;
                                                    }
                                                    }
                                                    @endphp
                                                    @if($tarifreja==1)
                                        <table class="rbt-table table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>T/r</th>
                                                    <th>Tarif reja</th>
                                                    <th>Fanlar</th>
                                                    <th>Narxi</th>
                                                    <th>Sana</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($my_tariffs as $tariff_rejalari)         
                                                <tr>
                                                    <th>{{$loop->iteration}}</th>
                                                    <td>{{$tariff_rejalari['tariff']['name']}}</td>
                                                    <td>{{$tariff_rejalari['tariff']['subjects']}}</td>
                                                    <td>{{$tariff_rejalari['tariff']['total_price']}}</td>
                                                    <td>{{$tariff_rejalari['end_at']}}</td>
                                                    <td>
                                                        @if($tariff_rejalari['is_active'] == true)
                                                        <span class="rbt-badge-5 bg-color-success-opacity color-success">Faol</span>
                                                        @else
                                                        <span class="rbt-badge-5 bg-color-danger-opacity color-danger">Faol emas</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <div class="cart-table table-responsive">
                                            <p class="text-center">Platforma imkoniyatidan to‘liq foydalanish uchun quyidagi tariflardan birini tanlang!</p>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="pro-title">Ta’riflar</th>
                                            <th class="pro-price">Narxi</th>
                                            <th class="pro-quantity">Fanlar</th>
                                            <th class="pro-subtotal">Umumiy narxi</th>
                                            <th class="pro-remove">To‘lov</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @foreach($tariffs as $tariff)
                                <tr>
                                <td class="pro-title"><a href="#">{{ $tariff['name'] }}</a></td>
                                <td class="pro-price"><span>{{ number_format($tariff['price'], 0, '', ' ') }} so‘m</span></td>
                                <td class="pro-price">
                                <span>
                                @foreach($userData['subjects'] as $subject)
                                {{ $loop->last ? $subject['name'] : $subject['name'] . ',' }}
                                @endforeach
                                </span>
                                </td>
                                <td class="pro-subtotal">
                                <span>{{ number_format($tariff['total_price'], 0, '', ' ') }} so‘m</span>
                                </td>
                                <td><a class="rbt-btn btn-gradient" href="{{ route('user.buy.tariff', $tariff['id']) }}">Xarid qilish</a></td>
                                </tr>
                                @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                        @endif
                                    </div>
                                    </div>
                                            </div>

                                        <div class="tab-pane fade" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                                            <div class="row g-5">
                                                @foreach($tariffs as $tariff)
                <!-- Start Single Pricing  -->
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table style-2 price-user-profile">
                        <div class="pricing-header">
                            @if($tariff['is_popular'] == 1)
                            <div class="pricing-badge"><span>Ommabop</span></div>
                            @endif
                            <h3 class="title">{{$tariff['name']}}</h3>
                            <span class="rbt-badge mb--35">Bitta fan uchun</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount">{{$tariff['price']}}</span>
                                    <span class="duration">/so‘m</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount">{{$tariff['price']}}</span>
                                    <span class="duration">/so‘m</span>
                                </div>
                            </div>
                        </div>

                        <div class="pricing-btn">
                            <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100" href="/user/buy_tariff/{{ $tariff['id'] }}">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Xarid qilish</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Single Pricing  -->
                @endforeach
            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Enrole Course  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Card Style -->
    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>
@endsection