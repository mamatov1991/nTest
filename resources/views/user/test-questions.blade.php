    @extends('user.test-layout')

    @section('main')
    <div class="row g-5">         

    <div class="col-lg-12">
    <h5 class="text-center">{{ $subject_name }}</h5>
    <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
    <div class="inner">
    <div class="content">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <form id="quiz-form" class="quiz-form-wrapper">
    <input type="hidden" name="test_id" value="{{ $test_id }}">
    <div class="quize-top-meta mb-3">
    <div class="quize-top-left">
    <span>Bo‘lim nomi: <strong>{{ $chapter_name }}</strong></span>
    <span>Savollar soni: <strong>{{ count($chapter_questions) }} ta</strong></span>
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
    @foreach ($chapter_questions as $index => $question)
    <li>
    <a href="#" class="nav-btn" data-index="{{ $loop->iteration }}">{{ $loop->iteration }}</a>
    </li>
    @endforeach
    </ul>
    </nav>
    </div>
    </div>
    @foreach ($chapter_questions as $index => $question)
    <div class="question d-none" id="question-{{ $loop->iteration }}">
    <div class="question-text mt--30">
    <span>{{ $loop->iteration }}.</span> <span>{!!$question['id']!!} {!! $question['question'] ?? 'Savol matni yo‘q' !!}</span>
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
    id="option-{{ $option['id'] ?? uniqid() }}">
    <label class="form-check-label" for="option-{{ $option['id'] ?? uniqid() }}">
    {{ chr(65 + $optIndex) }}) {{ $option['body'] ?? 'Variant yo‘q' }}
    </label>
    </p>
    </div>
    @endforeach
    </div>
    </div>
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
    const totalQuestions = {{ count($chapter_questions) }};
    const isNewTest = {{ $isNewTest ? 'true' : 'false' }};
    let answers;
    let remainingTime;
    let countdownInterval;

    if (isNewTest) {
    localStorage.removeItem('quizAnswers');
    localStorage.removeItem('remainingTime');
    answers = {};
    remainingTime = {{ $remaining_time }};
    const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
    history.replaceState({}, document.title, newUrl);
    } else {
    answers = JSON.parse(localStorage.getItem('quizAnswers')) || {{ json_encode($userAnswers) }} || {};
    remainingTime = localStorage.getItem('remainingTime') ? parseInt(localStorage.getItem('remainingTime')) : {{ $remaining_time }};
    }

    const submitBtn = document.getElementById('submit-test');
    const btnText = submitBtn ? submitBtn.querySelector('.btn-text') : null;
    const countdownElem = document.getElementById('countdown');

    function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }

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

    function showQuestion(index) {
    const questionElements = document.querySelectorAll('.question');
    if (!questionElements.length) return;

    questionElements.forEach(q => q.classList.add('d-none'));
    const questionElem = document.getElementById('question-' + index);
    if (!questionElem) return;
    questionElem.classList.remove('d-none');
    questionElem.querySelectorAll('.answer-option').forEach(opt => {
    opt.checked = answers[opt.dataset.questionId] === opt.value;
    });

    const navButtons = document.querySelectorAll('.rbt-pagination li a');
    navButtons.forEach(btn => {
    btn.parentElement.classList.remove('active');
    const questionId = document.getElementById('question-' + btn.dataset.index)?.querySelector('.answer-option')?.dataset.questionId;
    if (questionId && answers[questionId]) {
    btn.classList.add('answered');
    } else {
    btn.classList.remove('answered');
    }
    });

    const navBtn = document.querySelector(`.rbt-pagination li a[data-index="${index}"]`);
    if (navBtn) {
    navBtn.parentElement.classList.add('active');
    }
    currentQuestion = parseInt(index);
    if (btnText) {
    btnText.textContent = currentQuestion === totalQuestions ? 'Testni tugatish' : 'Keyingi';
    }
    }

    const answerOptions = document.querySelectorAll('.answer-option');
    if (answerOptions.length > 0) {
    answerOptions.forEach(opt => {
    opt.addEventListener('change', function() {
    const qId = this.dataset.questionId;
    const value = this.value;
    answers[qId] = value;
    localStorage.setItem('quizAnswers', JSON.stringify(answers));
    const currentNavBtn = document.querySelector(`.rbt-pagination li a[data-index="${currentQuestion}"]`);
    if (currentNavBtn) {
    currentNavBtn.classList.add('answered');
    }
    console.log('Updated answers:', answers);
    });
    });
    }
    const navButtons = document.querySelectorAll('.rbt-pagination li a');
    if (navButtons.length > 0) {
    navButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
    e.preventDefault();
    showQuestion(this.dataset.index);
    });
    });
    }
    function submitTest() {
    const testId = {{ $test_id ?? 'null' }};
    if (!testId || isNaN(parseInt(testId))) {
    alert("Test ID noto'g'ri! Sahifani qayta yuklang.");
    return;
    }

    const payload = {
    test_id: parseInt(testId),
    answers: Object.keys(answers)
    .filter(qId => answers[qId])
    .map(qId => ({ 
    id: parseInt(qId),
    answer: answers[qId]
    }))
    };


    if (payload.answers.length === 0) {
    alert("Iltimos, kamida bitta savolga javob bering!");
    return;
    }

    console.log('Payload:', payload);

    fetch("{{ route('user.submit.test') }}", {
    method: "POST",
    headers: {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify(payload)
    })
    .then(res => {
    console.log('Response status:', res.status);
    if (!res.ok) {
    return res.json().then(data => {
    throw new Error(data.message || 'Server xatosi: ' + JSON.stringify(data.errors || {}));
    });
    }
    return res.json();
    })
    .then(data => {
    if (data.success) {
    let answerDetails = payload.answers.map(item => 
    `Savol ID: ${item.id}, Javob: ${item.answer}`
    ).join('\n');
    // alert(`${data.message} \n\nYuborilgan javoblar:\n${answerDetails}\n\nNatijalar:\nScore: ${data.data?.score || 'Noma\'lum'}`);
    } else {
    // alert("API xatosi: " + (data.message || 'Noma\'lum xato'));
    }
    localStorage.removeItem('quizAnswers');
    localStorage.removeItem('remainingTime');
    clearInterval(countdownInterval);
    window.location.href = "{{ route('user.test.results') }}";
    })
    .catch(err => {
    console.error('Error:', err.message);
    });
    }

    if (submitBtn) {
    submitBtn.addEventListener('click', function(e) {
    e.preventDefault();
    if (currentQuestion < totalQuestions) {
    showQuestion(currentQuestion + 1);
    } else {
    const unanswered = [];
    for (let i = 1; i <= totalQuestions; i++) {
    const qId = document.getElementById('question-' + i)?.querySelector('.answer-option')?.dataset.questionId;
    if (qId && !answers[qId]) {
    unanswered.push(i);
    }
    }

    if (unanswered.length > 0) {
    Swal.fire({
    title: 'Javob berilmagan savollar mavjud!',
    text: 'Testni yakunlamoqchimisiz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ha, yakunlash',
    cancelButtonText: 'Yo‘q, davom etish'
    }).then((result) => {
    if (result.isConfirmed) {
    submitTest();
    } else {
    showQuestion(unanswered[0]);
    }
    });
    } else {
    submitTest();
    }
    }
    });
    }

    showQuestion(1);
    countdownElem.textContent = formatTime(remainingTime);
    startCountdown();
    });
    </script>


    @endsection
