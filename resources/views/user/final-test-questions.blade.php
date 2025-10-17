@extends('user.test-layout')

@section('main')
<div class="row g-5">         

<div class="col-lg-12">
<h5 class="text-center">{{ $all_final_test_params['test']['subject']['name'] }} ({{ $all_final_test_params['test']['type'] }})</h5>
<div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
<div class="inner">
<div class="content">
<meta name="csrf-token" content="{{ csrf_token() }}">
<form id="quiz-form" class="quiz-form-wrapper">
    <input type="hidden" name="student_final_test_id" value="{{ $student_final_test_id }}">

    <div class="quize-top-meta mb-3">
        <div class="quize-top-left">
            <span>Yakuniy test: <strong>{{ $all_final_test_params['test']['name'] }}</strong></span>
            <span>Savollar soni: <strong>{{ count($final_test_questions) }} ta</strong></span>
        </div>
        <div class="quize-top-right">
            <span>Vaqt: <strong id="countdown">{{ gmdate('i:s', $remaining_time) }}</strong></span>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-12">
            <nav>
                <ul id="quiz-nav" class="rbt-pagination justify-content-start">
                    @foreach ($final_test_questions as $index => $question)
                        <li>
                            <a href="#" class="nav-btn" data-index="{{ $loop->iteration }}">{{ $loop->iteration }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>

    @foreach ($final_test_questions as $index => $question)
        {{-- Choose Option --}}
        @if($question['type'] == 'choose_option')
            <div class="question d-none" id="question-{{ $loop->iteration }}">
                
                    <div class="row mt--30">
                    @if( Str::length($question['instruction']) > 25 )
                    <p>{!! Str::length($question['instruction']) !!}</p>
                    <div class="col-lg-12">
                    <div class="instruction">
                        {!! $question['instruction'] !!}        
                    </div>
                    </div>
                    @endif
                    
                    <div class="col-lg-12">
                    <div class="question-text mt--30">
                    <span>{{ $loop->iteration }}.</span> 
                    <span> {!! $question['question'] ?? 'Savol matni yo‘q' !!}</span>
                    </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    @foreach ($question['options'] ?? [] as $optIndex => $option)
                        <div class="col-lg-12">
                            <p class="rbt-checkbox-wrapper mb-2">
                                <input class="form-check-input answer-option"
       type="radio"
       name="question_{{ $question['detail_id'] ?? $loop->parent->iteration }}"
       data-question-id="{{ $question['detail_id'] ?? 'unknown' }}"
       value="{{ $option['id'] ?? '' }}"
       id="option-{{ $question['detail_id'] ?? $loop->parent->iteration }}-{{ $optIndex }}">
                                <label class="form-check-label" for="option-{{ $question['detail_id'] ?? $loop->parent->iteration }}-{{ $optIndex }}">
                                    {{ chr(65 + $optIndex) }}) {{ $option['body'] ?? 'Variant yo‘q' }}
                                </label>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Fill Gap --}}
        @if($question['type'] == 'fill_gap')
            <div class="question d-none" id="question-{{ $loop->iteration }}">
                <div class="question-text mt--30">
                    <span>{{ $loop->iteration }}.</span> 
                    <span>{!! $question['id'] !!} {!! $question['question'] ?? 'Savol matni yo‘q' !!}</span>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input name="question_{{ $loop->iteration }}" 
                                   type="text" 
                                   class="answer-text"
                                   data-question-id="{{ $question['detail_id'] ?? 'unknown' }}"
                                   placeholder="Javobni shu yerga yozing...">
                            <span class="focus-border"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Double Fill Gap --}}
@if($question['type'] == 'double_fill_gap')
<div class="question d-none" id="question-{{ $loop->iteration }}">
    <div class="question-text mt--30">
        <span>{{ $loop->iteration }}.</span>
        <span>{!! $question['question'] ?? 'Savol matni yo‘q' !!}</span>
    </div>
    <div class="row g-3 mt-2">
        <div class="col-lg-12">
            <span>{!! $question['question1'] ?? 'Savol matni yo‘q' !!}</span>
            <div class="form-group">
                <input name="question1_{{ $loop->iteration }}" type="text" 
                       class="answer-text double-gap-input" 
                       data-question-id="{{ $question['detail_id'] ?? '' }}"
                       data-gap="1"
                       placeholder="Javobni shu yerga yozing...">
                <span class="focus-border"></span>
            </div>
        </div>
        <div class="col-lg-12">
            <span>{!! $question['question2'] ?? 'Savol matni yo‘q' !!}</span>
            <div class="form-group">
                <input name="question2_{{ $loop->iteration }}" type="text" 
                       class="answer-text double-gap-input" 
                       data-question-id="{{ $question['detail_id'] ?? '' }}" 
                       data-gap="2"
                       placeholder="Javobni shu yerga yozing...">
                <span class="focus-border"></span>
            </div>
        </div>
    </div>
</div>
@endif


        {{-- Esse --}}
        @if($question['type'] == 'esse')
            <div class="question d-none" id="question-{{ $loop->iteration }}">
                <div class="row g-3 mt-2">
                    <div class="col-lg-6">
                        <div class="rbt-single-quiz" style="height: 500px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                            <h5 class="text-center">ESSE</h5>
                            <div class="question-text mt--30">
                                <span>{{ $loop->iteration }}.</span> 
                                <span>{!! $question['detail_id'] !!} {!! $question['question'] ?? 'Savol matni yo‘q' !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 pl--20">
                        <div class="rbt-single-quiz">
                            <h5>Javob:</h5>
                            <div class="form-group">
                                <textarea style="min-height: 456px;" 
                                          name="question_{{ $loop->iteration }}"
                                          class="answer-textarea"
                                          data-question-id="{{ $question['detail_id'] ?? 'unknown' }}"
                                          placeholder="Esse matnini shu yerga yozing..."></textarea>
                                <span class="focus-border"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <div class="submit-btn mt-4">
        <button type="button" id="submit-test" class="rbt-btn btn-gradient hover-icon-reverse" style="float:right; padding-left: 50px;">
            <span class="icon-reverse-wrapper">
                <span class="btn-text">Testni tugatish</span>
                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
            </span>
        </button>
    </div>
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

@section('script')

<script>
document.addEventListener("DOMContentLoaded", function() {
    let currentQuestion = 1;
    const totalQuestions = {{ count($final_test_questions) }};
    const isNewTest = {{ $isNewTest ? 'true' : 'false' }};
    let answers;
    let remainingTime;
    let countdownInterval;

    // Yangi test bo'lsa, localStorage'ni tozalash
    if (isNewTest) {
        localStorage.removeItem('quizAnswers');
        localStorage.removeItem('remainingTime');
        answers = {};
        remainingTime = {{ $remaining_time }};
        const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
        history.replaceState({}, document.title, newUrl);
    } else {
        let storedAnswers = localStorage.getItem('quizAnswers');
        if (storedAnswers && storedAnswers !== 'null' && storedAnswers !== 'undefined') {
            try {
                answers = JSON.parse(storedAnswers);
                Object.keys(answers).forEach(qId => {
                    if (typeof answers[qId] === 'string') {
                        answers[qId] = { answer: answers[qId], type: 'unknown' };
                    }
                });
            } catch (e) {
                answers = {};
            }
        } else {
            answers = {{ json_encode($userAnswers ?: []) }};
        }
        remainingTime = localStorage.getItem('remainingTime') ? parseInt(localStorage.getItem('remainingTime')) : {{ $remaining_time }};
    }

    // 🔐 Identifikator: avval student_final_test_id, bo'lmasa test_id
    const studentFinalTestId = {{ $student_final_test_id ?? 'null' }};
    const fallbackTestId = {{ $test_id ?? 'null' }};
    const finalTestId = (studentFinalTestId !== null && studentFinalTestId !== undefined && studentFinalTestId !== 'null')
        ? parseInt(studentFinalTestId, 10)
        : ((fallbackTestId !== null && fallbackTestId !== undefined && fallbackTestId !== 'null') ? parseInt(fallbackTestId, 10) : null);

    if (finalTestId === null || isNaN(finalTestId)) {
        Swal.fire({
            title: 'Xatolik!',
            text: 'Test identifikatori topilmadi.',
            icon: 'error'
        });
    }

    const submitBtn = document.getElementById('submit-test');
    const btnText = submitBtn ? submitBtn.querySelector('.btn-text') : null;
    const countdownElem = document.getElementById('countdown');

    // ✅ Type ni aniqlash (DOM class lardan)
    function getTypeFromElement(el) {
        if (el.classList.contains('answer-option')) return 'choose_option';
        if (el.classList.contains('answer-text') || el.classList.contains('answer-textarea')) return 'fill_gap';
        return 'unknown';
    }

    // Vaqt formatlash
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }

    // Countdown
    function startCountdown() {
        if (!countdownElem) return;
        countdownInterval = setInterval(() => {
            remainingTime--;
            if (remainingTime <= 0) {
                clearInterval(countdownInterval);
                Swal.fire({
                    title: 'Vaqt tugadi!',
                    text: 'Test avtomatik yakunlanmoqda.',
                    icon: 'warning',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    submitFinalTest();
                });
            } else {
                countdownElem.textContent = formatTime(remainingTime);
                localStorage.setItem('remainingTime', remainingTime);
            }
        }, 1000);
    }

    // Savolni ko'rsatish
    function showQuestion(index) {
        const questionElements = document.querySelectorAll('.question');
        if (!questionElements.length) return;

        questionElements.forEach(q => q.classList.add('d-none'));
        const questionElem = document.getElementById('question-' + index);
        if (!questionElem) return;
        questionElem.classList.remove('d-none');

        // Radio tiklash
        questionElem.querySelectorAll('.answer-option').forEach(opt => {
            const qId = opt.dataset.questionId;
            if (answers[qId] && answers[qId].answer === opt.value) {
                opt.checked = true;
            } else {
                opt.checked = false;
            }
        });

        // Matnli maydonlarni tiklash (double'larni o'tkazib yubor)
        questionElem.querySelectorAll('.answer-text, .answer-textarea').forEach(el => {
            if (el.classList.contains('double-gap-input')) return;  // Double allaqachon tiklanadi
            const qId = el.dataset.questionId;
            if (answers[qId] && answers[qId].answer) {
                el.value = answers[qId].answer;
            } else {
                el.value = '';
            }
        });

        // Double gap tiklash (hidden yo'q, to'g'ridan-to'g'ri input'larga split)
        const doubleInputs = questionElem.querySelectorAll('.double-gap-input');
        if (doubleInputs.length === 2) {
            const qId = doubleInputs[0].dataset.questionId;  // Ikkalasi bir xil
            if (answers[qId] && answers[qId].answer) {
                const parts = answers[qId].answer.split(' | ');  // " | " formatida ajrat
                doubleInputs.forEach((input, idx) => {
                    input.value = parts[idx] || '';
                });
            }
        }

        // Type ni tiklash (unknown bo'lsa)
        questionElem.querySelectorAll('[data-question-id]').forEach(el => {
            const qId = el.dataset.questionId;
            if (answers[qId] && answers[qId].type === 'unknown') {
                answers[qId].type = getTypeFromElement(el);
                localStorage.setItem('quizAnswers', JSON.stringify(answers));
            }
        });

        // Navigatsiya status (double uchun input qId'ni ishlat, hidden yo'q)
        const navButtons = document.querySelectorAll('.rbt-pagination li a');
        navButtons.forEach(btn => {
            btn.parentElement.classList.remove('active');
            const questionIndex = btn.dataset.index;
            const questionDiv = document.getElementById('question-' + questionIndex);
            if (!questionDiv) return;

            const inputOrRadio = questionDiv.querySelector('[data-question-id]');
            const qId = inputOrRadio ? inputOrRadio.dataset.questionId : null;

            if (qId && answers[qId] && answers[qId].answer && answers[qId].answer !== '') {
                btn.classList.add('answered');
            } else {
                btn.classList.remove('answered');
            }
        });

        // Joriy savol
        const navBtn = document.querySelector(`.rbt-pagination li a[data-index="${index}"]`);
        if (navBtn) {
            navBtn.parentElement.classList.add('active');
        }

        currentQuestion = parseInt(index);
        if (btnText) {
            btnText.textContent = currentQuestion === totalQuestions ? 'Testni tugatish' : 'Keyingi';
        }
    }

    // ✅ Radio hodisasi
    document.querySelectorAll('.answer-option').forEach(opt => {
        opt.addEventListener('change', function() {
            const qId = this.dataset.questionId;
            answers[qId] = {
                answer: this.value,
                type: getTypeFromElement(this)
            };
            localStorage.setItem('quizAnswers', JSON.stringify(answers));

            const currentNavBtn = document.querySelector(`.rbt-pagination li a[data-index="${currentQuestion}"]`);
            if (currentNavBtn) currentNavBtn.classList.add('answered');
        });
    });

    // ✅ Double Fill Gap hodisasi (sodda: hidden yo'q, faqat " | " birlashtirish)
    document.querySelectorAll('.double-gap-input').forEach(el => {
        el.addEventListener('input', function() {
            const qId = this.dataset.questionId;  // Savol ID'si (ikkalasiga bir xil, masalan "474")
            if (!qId) {
                return;
            }
            
            // Shu savol ichidagi ikkala input'ni topish
            const input1 = document.querySelector(`.double-gap-input[data-question-id="${qId}"][data-gap="1"]`);
            const input2 = document.querySelector(`.double-gap-input[data-question-id="${qId}"][data-gap="2"]`);
            
            if (input1 && input2) {
                const answer1 = input1.value.trim() || '';
                const answer2 = input2.value.trim() || '';
                const combinedAnswer = answer1 + (answer1 && answer2 ? ' | ' : '') + answer2;  // "Salom | Qaleysan" yoki bo'sh

                // Answers'ni yangila (faqat shu qId'ga, har doim string)
                answers[qId] = {
                    answer: combinedAnswer,  // Bo'sh bo'lsa ham ''
                    type: 'fill_gap'  // Backend uchun
                };
                localStorage.setItem('quizAnswers', JSON.stringify(answers));

                // Navigatsiya status
                const currentNavBtn = document.querySelector(`.rbt-pagination li a[data-index="${currentQuestion}"]`);
                if (currentNavBtn && combinedAnswer.trim()) {
                    currentNavBtn.classList.add('answered');
                } else if (currentNavBtn) {
                    currentNavBtn.classList.remove('answered');
                }
            }
        });
    });

    // ✅ Matn hodisasi (double'larni o'tkazib yubor)
    document.querySelectorAll('.answer-text, .answer-textarea').forEach(el => {
        if (el.classList.contains('double-gap-input')) return;  // Double'ni o'z hodisasi hal qilsin
        el.addEventListener('input', function() {
            const qId = this.dataset.questionId;
            const value = this.value;
            answers[qId] = {
                answer: value,
                type: getTypeFromElement(this)
            };
            localStorage.setItem('quizAnswers', JSON.stringify(answers));

            const currentNavBtn = document.querySelector(`.rbt-pagination li a[data-index="${currentQuestion}"]`);
            if (currentNavBtn) {
                if (value.trim() !== '') {
                    currentNavBtn.classList.add('answered');
                } else {
                    currentNavBtn.classList.remove('answered');
                }
            }
        });
    });

    // Navigatsiya tugmalari
    const navButtons = document.querySelectorAll('.rbt-pagination li a');
    navButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            showQuestion(this.dataset.index);
        });
    });

    // ✅ Yuborish: talab qilingan formatga mos (bo'sh answer'larni ham yubor, filter'dan o'tkazma)
    function submitFinalTest() {
        if (finalTestId === null || isNaN(finalTestId)) {
            Swal.fire({
                title: 'Xatolik!',
                text: 'Test identifikatori topilmadi.',
                icon: 'error'
            });
            return;
        }

        const answersArray = Object.entries(answers)
            .map(([qId, obj]) => ({
                id: parseInt(qId, 10),
                type: obj.type || 'unknown',
                answer: obj.answer || ''  // Bo'sh bo'lsa ham yubor
            }));

        const payload = {
            student_final_test_id: finalTestId,
            answers: answersArray
        };

        fetch("{{ route('user.submit.final.test') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(err => Promise.reject(err));
            }
            return res.json();
        })
        .then(data => {
            localStorage.removeItem('quizAnswers');
            localStorage.removeItem('remainingTime');
            clearInterval(countdownInterval);
            window.location.href = "{{ route('user.final.test.results') }}";
        })
        .catch(err => {
            Swal.fire({
                title: 'Xatolik yuz berdi!',
                text: err.message || 'Noma\'lum xato',
                icon: 'error'
            });
        });
    }

    // Submit tugmasi
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentQuestion < totalQuestions) {
                showQuestion(currentQuestion + 1);
            } else {
                // Javob berilmagan savollarni tekshirish
                const unanswered = [];
                for (let i = 1; i <= totalQuestions; i++) {
                    const questionDiv = document.getElementById('question-' + i);
                    if (!questionDiv) continue;
                    const inputOrRadio = questionDiv.querySelector('[data-question-id]');
                    const qId = inputOrRadio ? inputOrRadio.dataset.questionId : null;
                    if (qId && (!answers[qId] || !answers[qId].answer || answers[qId].answer === '')) {
                        unanswered.push(i);
                    }
                }

                if (unanswered.length > 0) {
                    Swal.fire({
                        title: 'Javob berilmagan savollar mavjud!',
                        text: `Testni yakunlamoqchimisiz? (Savollar: ${unanswered.join(', ')})`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ha, yakunlash',
                        cancelButtonText: 'Yo\'q, davom etish'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            submitFinalTest();
                        } else {
                            showQuestion(unanswered[0]);
                        }
                    });
                } else {
                    submitFinalTest();
                }
            }
        });
    }

    // Dastlabki holat
    showQuestion(1);
    if (countdownElem) {
        countdownElem.textContent = formatTime(remainingTime);
        startCountdown();
    }
});
</script>

<!-- <script>
document.querySelectorAll('.answer-option').forEach(opt => {
console.log('Question ID:', opt.dataset.questionId, 'Value:', opt.value);
});
</script> -->


@endsection
