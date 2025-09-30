@extends('user.test-layout')

@section('main')
<div class="row g-5">
                        

                        <div class="col-lg-12">
                        <h5 class="text-center">
                        {{ $chapter_result_data['chapter_id']['subject']['name'] ?? '' }} ({{ $chapter_result_data['chapter_id']['test_type']['name'] ?? '' }})
                        </h5>
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
                                <div class="inner">
                            <div class="content">
                               
                        <form id="quiz-form" class="quiz-form-wrapper">
                            <!-- Start Single Quiz  -->
                            <div id="question-1" class="question">
                                <div class="quize-top-meta">
                                    <div class="quize-top-left">
                                        <span>Bo‘lim nomi: <strong>{{ $chapter_result_data['chapter_id']['name'] ?? '' }}</strong></span>
                                        <span>Savollar soni: <strong>{{ count($chapter_result_data['results'] ?? []) }} ta</strong></span>

                                    </div>
                                    <div class="quize-top-right">
                                    @php
                                    use Carbon\Carbon;

                                    $start = Carbon::parse($chapter_result_data['start_at']);
                                    $end   = Carbon::parse($chapter_result_data['end_at']);
                                    $spent = $end->diff($start)->format('%i:%S');
                                    @endphp

                                    <span> Sarflangan vaqt: <strong>{{ $spent }}</strong></span>
                                    </div>

                                </div>
                                <hr>
                                <nav>
                                    <div class="nav-links mb--30">
                                        <h5 class="text-center">Natija</h5>
                                    </div>
                                </nav>
                                <table class="rbt-table table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Variant</th>
                                                    <th>Jami test soni</th>
                                                    <th>To‘g‘ri javoblar</th>
                                                    <th>Noto‘g‘ri javoblar</th>
                                                    <th>Ball</th>
                                                    <th>Sana</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1-variant</td>
                                                    <td>34 ta</td>
                                                    <td>25 ta</td>
                                                    <td>9 ta</td>
                                                    <td>56 ball</td>
                                                    <td>12.09.2025</td>
                                                </tr>

                                            </tbody>

                                        </table>
                                        <p><b>Izoh: </b> <i>Ochiq testlar va esse natijalari 3 kun ichida tekshiriladi. Umumiy ball va darajangizni <a href="#">Natijalar</a> bo‘limidan ko‘rishingiz mumkin bo‘ladi.</i></p>
                            <hr>
                            <h5 class="text-center">Hisobot</h5>
                            <div class="rbt-single-quiz">
                                    <h5>1. Imloviy jihatdan <b> to‘g‘ri yozilgan so‘zlar qatorini aniqlang. </b></h5>
                                    <div class="row g-3 mt--10">
                                        <div class="col-lg-12">
                                            <p class="rbt-checkbox-wrapper mb--5" style="background-color: rgb(210, 253, 170); padding: 10px;">
                                                <input class="form-check-input" type="radio" checked name="rbt-radio1" id="rbt-radio-1-1">
                                        <label class="form-check-label" for="rbt-radio-1"> A) taassuf, murojatnoma, tabiiy </label>
                                        <i class="feather-check" style="float: right; color: rgb(6, 139, 35); font-size: 20px; font-weight: 600;"></i>
                                            </p>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="rbt-checkbox-wrapper">
                                                <input class="form-check-input" type="radio" name="rbt-radio1" id="rbt-radio-1-2">
                                        <label class="form-check-label" for="rbt-radio-2"> B) tanazzul, muassasa, ma’dad</label>
                                            </p>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="rbt-checkbox-wrapper">
                                                <input class="form-check-input" type="radio" name="rbt-radio1" id="rbt-radio-1-3">
                                        <label class="form-check-label" for="rbt-radio-3"> C) muvofiq, taasurot, taalluqli</label>
                                            </p>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="rbt-checkbox-wrapper">
                                                <input class="form-check-input" type="radio" name="rbt-radio1" id="rbt-radio-1-4">
                                        <label class="form-check-label" for="rbt-radio-4"> D) maishiy, tafovut, tafakkur</label>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rbt-single-quiz mt--40">
                                    <h5>2. Qaysi gapda <b>ochiq</b> so‘zi <b></b>o‘z ma’nosida qo‘llangan?</b></h5>
                                    <div class="row g-3 mt--10">
                                        <div class="col-lg-12">
                                            <p class="rbt-checkbox-wrapper mb--5">
                                                <input class="form-check-input" type="radio" name="rbt-radio" id="rbt-radio-1">
                                        <label class="form-check-label" for="rbt-radio-1"> A) Nafisa o‘z fikrlarini ko‘pchilik oldida ham
ochiq ifoda qila olardi.</label>
                                            </p>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="rbt-checkbox-wrapper" style="background-color: rgb(253, 170, 170); padding: 10px;">
                                                <input class="form-check-input" type="radio" checked name="rbt-radio" id="rbt-radio-2">
                                        <label class="form-check-label" for="rbt-radio-2"> B) Yig‘ilishda aytilgan anchagina muammolar
ochiq qoldi.</label><i class="feather-x" style="float: right; color: rgb(139, 6, 6); font-size: 20px; font-weight: 600;"></i>
                                            </p>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="rbt-checkbox-wrapper">
                                                <input class="form-check-input" type="radio" name="rbt-radio" id="rbt-radio-3">
                                        <label class="form-check-label" for="rbt-radio-3"> C) Haftaning dushanba kuni ochiq eshiklar kuni
deb e’lon qilindi.</label>
                                            </p>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="rbt-checkbox-wrapper">
                                                <input class="form-check-input" type="radio" name="rbt-radio" id="rbt-radio-4">
                                        <label class="form-check-label" for="rbt-radio-4"> D) Ismat ota ochiq derazadan boshini chiqarib,
o‘g‘lini chaqirdi.</label>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                           
                                    </div>
                            <!-- Start Single Quiz  -->


                        </form>
                    </div>
                            </div>
                            </div>
                            </div>
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
