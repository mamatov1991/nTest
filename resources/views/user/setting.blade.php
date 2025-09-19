@extends('user.layout')

@section('main')
<div class="col-lg-9">
                            <!-- Start Enrole Course  -->
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                                <div class="content">

                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">Sozlamalar</h4>
                                    </div>

                                    <div class="advance-tab-button mb--30">
                                        <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="myTab-4" role="tablist">
                                            <li role="presentation">
                                                <a href="#" class="tab-button active" id="home-tab-4" data-bs-toggle="tab" data-bs-target="#home-4" role="tab" aria-controls="home-4" aria-selected="true">
                                                    <span class="title">Ma’lumotlarni tahrirlash</span>
                                                </a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#" class="tab-button" id="profile-tab-4" data-bs-toggle="tab" data-bs-target="#profile-4" role="tab" aria-controls="profile-4" aria-selected="false">
                                                    <span class="title">Parolni o‘zgartirish</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="home-4" role="tabpanel" aria-labelledby="home-tab-4">
                                            <div class="row g-5 mb--30">
                        <h4 class="title text-center">Tahrirlash</h4>
                        <form action="#" class="rbt-profile-row rbt-default-form row row--15">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--10">
                                                    <div class="rbt-form-group">
                                                        <input id="firstname" type="text" placeholder="Ism *" value="Abdullaev" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--10">
                                                    <div class="rbt-form-group">
                                                        <input id="lastname" type="text" placeholder="Familya *" value="Abdulloh" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                                                    <div class="filter-select rbt-modern-select">
                                                        <select id="displayname" class="w-100">
                                                            <option disabled>Hudud (viloyat) *</option>
                                                            <option selected>Andijon viloyati</option>
                                                            <option>Buxoro viloyati</option>
                                                            <option>Samarqand viloyati</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                                                    <div class="filter-select rbt-modern-select">
                                                        <select id="displayname" class="w-100">
                                                            <option disabled>Tuman yoki shahar *</option>
                                                            <option>Asaka tumani</option>                                                            
                                                            <option>Buloqboshi tumani</option>
                                                            <option>Marxamat tumani</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                                                    <div class="filter-select rbt-modern-select">
                                                        <select id="displayname" class="w-100">
                                                            <option disabled>Maktab (yoki bitirgan maktabi) *</option>
                                                            <option selected>14-maktab</option>
                                                            <option>247-maktab</option>
                                                            <option>248-maktab</option>
                                                            <option>249-maktab</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                                                    <div class="filter-select rbt-modern-select">
                                                        <select id="displayname" class="w-100">
                                                            <option>Bitirgan</option>
                                                            <option disabled>Sinfi *</option>
                                                            <option>1-sinf</option>
                                                            <option>2-sinf</option>
                                                            <option>3-sinf</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                                                <div class="filter-select rbt-modern-select">
                                                    <select class="w-100" data-live-search="true" title="Fanlar *" multiple data-size="7" data-actions-box="true" data-selected-text-format="count > 5">
                                                        <option selected>Ona tili</option>
                                                        <option selected>Matematika</option>
                                                        <option>Fizika</option>
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                                                    <div class="filter-select rbt-modern-select">
                                                        <select id="displayname" class="w-100">
                                                            <option disabled>Test tili *</option>
                                                            <option selected>O‘zbekcha</option>
                                                            <option>Русский</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                  <div class="rbt-form-group">
                                <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse" style="float: right; margin-right: 6px;">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Saqlash</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </button>
                            </div>
                            </div>
                                            </form>
                                    </div>
                                            </div>

                                        <div class="tab-pane fade" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                                            <div class="row g-5 mb--30">
                        <h4 class="title text-center">Parolni o‘zgartirish</h4>
                        <form action="#" class="rbt-profile-row rbt-default-form row row--15">
                                                
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb--10">
                                                    <div class="rbt-form-group">
                                                        <input type="password" placeholder="Oldingi parol *" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb--10">
                                                    <div class="rbt-form-group">
                                                        <input type="password" placeholder="Yangi parol *" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb--10">
                                                    <div class="rbt-form-group">
                                                        <input type="password" placeholder="Qaytadan yangi parol *" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                  <div class="rbt-form-group">
                                <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse" style="float: right; margin-right: 6px;">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Saqlash</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </button>
                            </div>
                            </div>
                                            </form>
                                    </div>
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