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
                    <div style="height: 300px; width: 100%; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
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
                            <input name="question1_{{ $loop->iteration }}" 
                                   type="text" 
                                   class="answer-text"
                                   data-question-id="{{ $question['detail_id'] . 5 . $question['id'] ?? 'unknown' }}"
                                   placeholder="Javobni shu yerga yozing...">
                            <span class="focus-border"></span>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <span>{!! $question['question2'] ?? 'Savol matni yo‘q' !!}</span>
                        <div class="form-group">
                            <input name="question2_{{ $loop->iteration }}" 
                                   type="text" 
                                   class="answer-text"
                                   data-question-id="{{ $question['detail_id'].$question['id'] ?? 'unknown' }}"
                                   placeholder="Javobni shu yerga yozing...">
                            <span class="focus-border"></span>
                        </div>
                        <input type="hidden" name="question_{{ $loop->iteration }}" value="" data-question-id="{{ $question['detail_id'] ?? 'unknown' }}">
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
    // Har bir savol blokini topamiz
    document.querySelectorAll('.row.g-3.mt-2').forEach(block => {
        const input1 = block.querySelector('input[name^="question1_"]');
        const input2 = block.querySelector('input[name^="question2_"]');
        const hidden = block.querySelector('input[type="hidden"][name^="question_"]');

        if (input1 && input2 && hidden) {
            function updateHiddenValue() {
                const val1 = input1.value.trim();
                const val2 = input2.value.trim();

                // Ikkalasini bitta stringga birlashtiramiz
                hidden.value = `${val1}${val1 && val2 ? ' | ' : ''}${val2}`;
                // ✅ Konsol uchun kuzatish
                console.log(`Hidden field (${hidden.name}) → ${hidden.value}`);
            }

            // Har safar yozilganda yangilansin
            input1.addEventListener('input', updateHiddenValue);
            input2.addEventListener('input', updateHiddenValue);

            // Dastlabki holatda ham to‘ldir
            updateHiddenValue();
        }
    });
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    let currentQuestion = 1;
    const totalQuestions = {{ count($final_test_questions) }};
    const isNewTest = {{ $isNewTest ? 'true' : 'false' }};

    // 🔐 Identifikator: avval student_final_test_id, bo'lmasa test_id
    const studentFinalTestId = {{ $student_final_test_id ?? 'null' }};
    const fallbackTestId = {{ $test_id ?? 'null' }};
    const finalTestId = (studentFinalTestId !== null && studentFinalTestId !== undefined && studentFinalTestId !== 'null')
        ? parseInt(studentFinalTestId, 10)
        : ((fallbackTestId !== null && fallbackTestId !== undefined && fallbackTestId !== 'null') ? parseInt(fallbackTestId, 10) : null);

    if (finalTestId === null || isNaN(finalTestId)) {
        console.error('❌ finalTestId aniqlanmadi yoki noto‘g‘ri formatda.');
        alert('Xatolik: test identifikatori topilmadi.');
    }

    // 🧪 Debug: RAM va localStorage holatini chiqarish
    function debugDump(label = '') {
        const ls = localStorage.getItem('quizAnswers');
        let parsed = null;
        try { parsed = JSON.parse(ls); } catch(e) {}
        console.log(`🧪 ${label} | answers (RAM):`, answers);
        console.log(`🧪 ${label} | localStorage (quizAnswers):`, parsed);
    }

    window.debugQuiz = function() {
        const v = JSON.parse(localStorage.getItem('quizAnswers'));
        console.log('🔎 debugQuiz():', v);
        return v;
    };

    // ✅ Javoblarni xavfsiz yuklash – {qId: {answer, type}}
    let answers;
    let storedAnswers = localStorage.getItem('quizAnswers');
    if (storedAnswers && storedAnswers !== 'null' && storedAnswers !== 'undefined') {
        try {
            answers = JSON.parse(storedAnswers);
            Object.keys(answers).forEach(qId => {
                if (typeof answers[qId] === 'string') {
                    answers[qId] = { answer: answers[qId], type: 'unknown' };
                }
            });
            console.log('📥 LocalStorage-dan yuklandi (quizAnswers):', answers);
        } catch (e) {
            console.warn('⚠️ LocalStorage parse xatosi, bo‘sh obyektga o‘tyapman:', e);
            answers = {};
        }
    } else {
        answers = {{ json_encode($userAnswers ?: []) }};
        console.log('📥 Backend (userAnswers) dan yuklandi:', answers);
    }

    let remainingTime = localStorage.getItem('remainingTime') ? parseInt(localStorage.getItem('remainingTime')) : {{ $remaining_time }};
    let countdownInterval;

    // Yangi test bo'lsa localStorage tozalash
    if (isNewTest) {
        localStorage.removeItem('quizAnswers');
        localStorage.removeItem('remainingTime');
        answers = {};
        remainingTime = {{ $remaining_time }};
        console.log('🧹 isNewTest=true — localStorage tozalandi.');
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
                console.log('⏱️ Vaqt tugadi — auto submit!');
                alert("Vaqt tugadi!");
                submitFinalTest();
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

        // Matnli maydonlarni tiklash
        questionElem.querySelectorAll('.answer-text, .answer-textarea').forEach(el => {
            const qId = el.dataset.questionId;
            if (answers[qId] && answers[qId].answer) {
                el.value = answers[qId].answer;
            } else {
                el.value = '';
            }
        });

        // Type ni tiklash (unknown bo'lsa)
        questionElem.querySelectorAll('[data-question-id]').forEach(el => {
            const qId = el.dataset.questionId;
            if (answers[qId] && answers[qId].type === 'unknown') {
                answers[qId].type = getTypeFromElement(el);
                localStorage.setItem('quizAnswers', JSON.stringify(answers));
            }
        });

        // Navigatsiya status
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

        console.log(`📄 showQuestion(${index}) — current answers:`, answers);
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
            debugDump(`change:qId=${qId}`);

            const currentNavBtn = document.querySelector(`.rbt-pagination li a[data-index="${currentQuestion}"]`);
            if (currentNavBtn) currentNavBtn.classList.add('answered');
        });
    });

    // ✅ Matn hodisasi
    document.querySelectorAll('.answer-text, .answer-textarea').forEach(el => {
        el.addEventListener('input', function() {
            const qId = this.dataset.questionId;
            const value = this.value;
            answers[qId] = {
                answer: value,
                type: getTypeFromElement(this)
            };
            localStorage.setItem('quizAnswers', JSON.stringify(answers));
            debugDump(`input:qId=${qId}`);

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

    // ✅ Yuborish: talab qilingan formatga mos
    function submitFinalTest() {
        if (finalTestId === null || isNaN(finalTestId)) {
            console.error('❌ finalTestId mavjud emas yoki noto‘g‘ri.');
            alert('Xatolik: test identifikatori topilmadi.');
            return;
        }

        const answersArray = Object.entries(answers)
            .filter(([_, obj]) => obj && obj.answer !== '' && obj.answer !== null && obj.answer !== undefined)
            .map(([qId, obj]) => ({
                id: parseInt(qId, 10),
                type: obj.type || 'unknown',
                answer: obj.answer
            }));

        const payload = {
            student_final_test_id: finalTestId, // ✅ Endi RAQAM sifatida!
            answers: answersArray
        };

        console.log('📦 Yuborilayotgan payload:', JSON.stringify(payload, null, 2));

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
            console.log('✅ Server javobi:', data);
            localStorage.removeItem('quizAnswers');
            localStorage.removeItem('remainingTime');
            clearInterval(countdownInterval);
            window.location.href = "{{ route('user.final.test.results') }}";
        })
        .catch(err => {
            console.error('❌ Yuborishda xatolik:', err);
            alert('Xatolik yuz berdi: ' + (err.message || 'Noma\'lum xato'));
        });
    }

    // Submit tugmasi
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentQuestion < totalQuestions) {
                showQuestion(currentQuestion + 1);
            } else {
                submitFinalTest();
            }
        });
    }

    // Dastlabki holat
    showQuestion(1);
    if (countdownElem) {
        countdownElem.textContent = formatTime(remainingTime);
        startCountdown();
    }

    debugDump('init');
});
</script>



<!-- <script>
document.querySelectorAll('.answer-option').forEach(opt => {
console.log('Question ID:', opt.dataset.questionId, 'Value:', opt.value);
});
</script> -->


@endsection
