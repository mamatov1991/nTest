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
    <input type="hidden" name="test_id" value="{{ $test_id }}">

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
                <div class="question-text mt--30">
                    <span>{{ $loop->iteration }}.</span> 
                    <span>{!! $question['id'] !!} {!! $question['question'] ?? 'Savol matni yo‘q' !!}</span>
                </div>
                <div class="row g-3 mt-2">
                    @foreach ($question['options'] ?? [] as $optIndex => $option)
                        <div class="col-lg-12">
                            <p class="rbt-checkbox-wrapper mb-2">
                                <input class="form-check-input answer-option"
                                       type="radio"
                                       name="question_{{ $loop->iteration }}"
                                       data-question-id="{{ $question['id'] ?? 'unknown' }}"
                                       value="{{ $option['id'] ?? '' }}"
                                       id="option-{{ $loop->iteration }}-{{ $optIndex }}">
                                <label class="form-check-label" for="option-{{ $loop->iteration }}-{{ $optIndex }}">
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
                                   data-question-id="{{ $question['id'] ?? 'unknown' }}"
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
                                <span>{!! $question['id'] !!} {!! $question['question'] ?? 'Savol matni yo‘q' !!}</span>
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
                                          data-question-id="{{ $question['id'] ?? 'unknown' }}"
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

    // Javoblarni xavfsiz yuklash
    let answers;
    let storedAnswers = localStorage.getItem('quizAnswers');
    if (storedAnswers && storedAnswers !== 'null' && storedAnswers !== 'undefined') {
        try {
            answers = JSON.parse(storedAnswers);
        } catch (e) {
            answers = {};
        }
    } else {
        answers = {{ json_encode($userAnswers ?: []) }};
    }

    let remainingTime = localStorage.getItem('remainingTime') ? parseInt(localStorage.getItem('remainingTime')) : {{ $remaining_time }};
    let countdownInterval;

    // Yangi test bo'lsa localStorage tozalash
    if (isNewTest) {
        localStorage.removeItem('quizAnswers');
        localStorage.removeItem('remainingTime');
        answers = {};
        remainingTime = {{ $remaining_time }};
    }

    const submitBtn = document.getElementById('submit-test');
    const btnText = submitBtn ? submitBtn.querySelector('.btn-text') : null;
    const countdownElem = document.getElementById('countdown');

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
                alert("Vaqt tugadi!");
                submitTest();
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

        // Radio tugmalar uchun javobni tiklash
        questionElem.querySelectorAll('.answer-option').forEach(opt => {
            if (answers[opt.dataset.questionId] === opt.value) {
                opt.checked = true;
            } else {
                opt.checked = false;
            }
        });

        // Matnli maydonlar (fill gap, esse) uchun javobni tiklash
        questionElem.querySelectorAll('.answer-text, .answer-textarea').forEach(el => {
            const qId = el.dataset.questionId;
            if (answers.hasOwnProperty(qId)) {
                el.value = answers[qId];
            } else {
                el.value = '';
            }
        });

        // Navigatsiya tugmalarini yangilash — faqat joriy savol ID sini ishlatish
        const navButtons = document.querySelectorAll('.rbt-pagination li a');
        navButtons.forEach(btn => {
            btn.parentElement.classList.remove('active');
            const questionIndex = btn.dataset.index;
            const questionDiv = document.getElementById('question-' + questionIndex);
            if (!questionDiv) return;

            const inputOrRadio = questionDiv.querySelector('[data-question-id]');
            const qId = inputOrRadio ? inputOrRadio.dataset.questionId : null;

            if (qId && answers.hasOwnProperty(qId) && answers[qId] !== '') {
                btn.classList.add('answered');
            } else {
                btn.classList.remove('answered');
            }
        });

        // Joriy savolni belgilash
        const navBtn = document.querySelector(`.rbt-pagination li a[data-index="${index}"]`);
        if (navBtn) {
            navBtn.parentElement.classList.add('active');
        }

        currentQuestion = parseInt(index);
        if (btnText) {
            btnText.textContent = currentQuestion === totalQuestions ? 'Testni tugatish' : 'Keyingi';
        }
    }

    // Radio tugmalar uchun hodisa
    document.querySelectorAll('.answer-option').forEach(opt => {
        opt.addEventListener('change', function() {
            const qId = this.dataset.questionId;
            answers[qId] = this.value;
            localStorage.setItem('quizAnswers', JSON.stringify(answers));
            const currentNavBtn = document.querySelector(`.rbt-pagination li a[data-index="${currentQuestion}"]`);
            if (currentNavBtn) currentNavBtn.classList.add('answered');
        });
    });

    // Matn kiritish (fill gap, esse) uchun hodisa
    document.querySelectorAll('.answer-text, .answer-textarea').forEach(el => {
        el.addEventListener('input', function() {
            const qId = this.dataset.questionId;
            const value = this.value; // .trim() qilmasa ham bo'ladi, lekin kerak bo'lsa qo'shing
            answers[qId] = value;
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

    // Navigatsiya tugmalariga bosish
    const navButtons = document.querySelectorAll('.rbt-pagination li a');
    navButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            showQuestion(this.dataset.index);
        });
    });

    // Testni yuborish
    function submitTest() {
        const testId = {{ $test_id ?? 'null' }};
        const payload = {
            test_id: parseInt(testId),
            answers: Object.entries(answers)
                .filter(([qId, ans]) => ans !== '' && ans !== null && ans !== undefined)
                .map(([qId, ans]) => ({
                    id: parseInt(qId),
                    answer: ans // ✅ matn yoki variant ID — to'g'ri saqlanadi
                }))
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
        .then(res => res.json())
        .then(data => {
            localStorage.removeItem('quizAnswers');
            localStorage.removeItem('remainingTime');
            clearInterval(countdownInterval);
            window.location.href = "{{ route('user.final.test.results') }}";
        })
        .catch(err => console.error('Yuborishda xatolik:', err));
    }

    // Submit tugmasi
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentQuestion < totalQuestions) {
                showQuestion(currentQuestion + 1);
            } else {
                submitTest();
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

<script>
document.querySelectorAll('.answer-option').forEach(opt => {
console.log('Question ID:', opt.dataset.questionId, 'Value:', opt.value);
});
</script>


@endsection
