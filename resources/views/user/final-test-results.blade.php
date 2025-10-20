@extends('user.test-layout')

@section('main')
<div class="row g-5">
                        

                        <div class="col-lg-12">
                        <h5 class="text-center">
                        {{ $final_test_result_data['final_test']['subject']['name'] ?? '' }} ({{ $final_test_result_data['final_test']['type'] ?? '' }})
                        </h5>
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
                                <div class="inner">
                            <div class="content">
                               
                        <form id="quiz-form" class="quiz-form-wrapper">
                            <!-- Start Single Quiz  -->
                            <div id="question-1" class="question">
                                <div class="quize-top-meta">
                                    <div class="quize-top-left">
                                        <span>Yakuniy test: <strong>{{ $final_test_result_data['final_test']['name'] ?? '' }}</strong></span>
                                        <span>Savollar soni: <strong>{{ count($final_test_result_data['details'] ?? []) }} ta</strong></span>

                                    </div>
                                    <div class="quize-top-right">
                                  

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
                                                    <th>Yopiq testlar soni</th>
                                                    <th>To‘g‘ri javoblar</th>
                                                    <th>Noto‘g‘ri javoblar</th>
                                                    <th>Sana</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $correct = 0;
                                                $incorrect = 0;
                                                $closedQuestions = 0;
                                                $score=0;
                                                $totalQuestions = count($final_test_result_data['details'] ?? []);
                                                foreach ($final_test_result_data['details'] ?? [] as $detail) {
                                                    if ($detail['is_correct'] == 1) {
                                                        $correct++;
                                                    } else if (($detail['is_correct'] == 0) && ($detail['testable_type'] == 'choose_option')) {
                                                        $incorrect++;
                                                    }
                                                    if ($detail['testable_type'] == 'choose_option') {
                                                        $closedQuestions++;
                                                        $score+=$detail['score'];
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $final_test_result_data['final_test']['name'] ?? '' }}</td>
                                                <td>{{ $totalQuestions }} ta</td>
                                                <td>{{ $closedQuestions }} ta</td>
                                                <td>{{ $correct }} ta</td>
                                                <td>{{ $incorrect }} ta</td>
                                                <td>{{ \Carbon\Carbon::parse($final_test_result_data['start_at'])->format('d.m.Y') }}</td>
                                            </tr>
                                        </tbody>

                                                                                </table>
                                                                                <p><b>Izoh: </b> <i> Yuqoridagi to‘g‘ri va noto‘g‘ri javoblar yopiq testlar soniga nisbatan hisoblangan. Ochiq testlar va esse natijalari <b>3 kun</b> ichida tekshiriladi. Umumiy ball va darajangizni <b><a href="/user/results">Natijalar</a></b> bo‘limidan ko‘rishingiz mumkin bo‘ladi.</i></p>
                                                                    <hr>
                                                                    <h5 class="text-center">Hisobot</h5>
                                                                    <div class="rbt-single-quiz">
                                                                    @foreach($final_test_result_data['details'] as $index => $result)
                                            @if($result['testable_type'] == 'choose_option')
                                                <div class="rbt-single-quiz mt--40">
                                                    <h5 class="result-ques">{{ $loop->iteration }}. {!! $result['question'] !!}</h5>

                                                    <div class="row g-3 mt--10">
                                                        @foreach($result['options'] as $optionIndex => $option)
                                                            @php
                                                                // Foydalanuvchi tanlagan variant
                                                                $isUserAnswer = $result['user_answer'] == $option['id'];
                                                                // To‘g‘ri variant
                                                                $isCorrect = $option['is_correct'];
                                                            @endphp

                                                            <div class="col-lg-12">
                                                                <p class="rbt-checkbox-wrapper mb--5"
                                                                style="background-color:
                                                                    @if($isUserAnswer && $isCorrect) rgb(210, 253, 170) {{-- foydalanuvchi to‘g‘ri javob bergan --}}
                                                                    @elseif($isUserAnswer && !$isCorrect) rgb(253, 170, 170) {{-- foydalanuvchi noto‘g‘ri javob bergan --}}
                                                                    @elseif(!$isUserAnswer && $isCorrect) rgb(210, 253, 170) {{-- to‘g‘ri javobni ko‘rsatish --}}
                                                                    @else transparent
                                                                    @endif;
                                                                    padding: 10px;">

                                                                    <input class="form-check-input" type="radio" 
                                                                        name="quiz-{{ $index }}" 
                                                                        id="option-{{ $option['id'] }}" 
                                                                        @if($isUserAnswer) checked @endif disabled>

                                                                    <label class="form-check-label" for="option-{{ $option['id'] }}">
                                                                        {{ chr(65 + $optionIndex) }}) {{ $option['body'] }}
                                                                    </label>

                                                                    {{-- Belgilar --}}
                                                                    @if($isUserAnswer && $isCorrect)
                                                                        <i class="feather-check" style="float: right; color: rgb(6, 139, 35); font-size: 20px; font-weight: 600;"></i>
                                                                    @elseif($isUserAnswer && !$isCorrect)
                                                                        <i class="feather-x" style="float: right; color: rgb(139, 6, 6); font-size: 20px; font-weight: 600;"></i>
                                                                    @elseif(!$isUserAnswer && $isCorrect)
                                                                        <i class="feather-check" style="float: right; color: rgb(6, 139, 35); font-size: 20px; font-weight: 600;"></i>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach



                    </div>
                    </div>
                    </div>

                    <div class="tutor-btn mt--40" style="float: right;">
                                    <a class="rbt-btn btn-md hover-icon-reverse" href="/user/main">
                                        <span class="icon-reverse-wrapper">
                        <span class="btn-text">Asosiy oynaga qaytish</span>
                                        <span class="btn-icon"><i class="feather-arrow-left"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-left"></i></span>
                                        </span>
                                    </a>
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
