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
                                                    <th>Bo‘lim nomi</th>
                                                    <th>Jami test soni</th>
                                                    <th>To‘g‘ri javoblar</th>
                                                    <th>Noto‘g‘ri javoblar</th>
                                                    <th>Ball</th>
                                                    <th>Sana</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @php
                                                    $results = $chapter_result_data['results'] ?? [];
                                                    $correctCount = collect($results)->where('is_correct', true)->count();
                                                    $wrongCount   = collect($results)->where('is_correct', false)->count();
                                                    @endphp
                                                    <td>{{ $chapter_result_data['chapter_id']['name'] ?? '' }}</td>
                                                    <td>{{ count($chapter_result_data['results'] ?? []) }} ta</td>
                                                    <td>{{ $correctCount }} ta</td>
                                                    <td>{{ $wrongCount }} ta</td>
                                                    <td>{{ ($chapter_result_data['score'] ?? 0) * 10 }} ball</td>
                                                    <td>{{ \Carbon\Carbon::parse($chapter_result_data['start_at'])->format('d.m.Y') }}</td>
                                                </tr>

                                            </tbody>

                                        </table>
                                          <hr>
                            <h5 class="text-center">Hisobot</h5>
                            <div class="rbt-single-quiz">
                            @foreach($chapter_result_data['results'] as $index => $result)
    <div class="rbt-single-quiz mt--40">
        {{-- Savol --}}
        <h5 class="result-ques">{{ $loop->iteration }}. {!! $result['question'] !!}</h5>

        <div class="row g-3 mt--10">
            @foreach($result['options'] as $optionIndex => $option)
                @php
                    // Foydalanuvchi tanlagan variant
                    $isUserAnswer = $result['answer_id'] === $option['id'];
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
@endforeach


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
    <!-- End Card Style -->
    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>
@endsection
