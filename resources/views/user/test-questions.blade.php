@extends('user.test-layout')

@section('main')
  <div class="row g-5">
                        

                        <div class="col-lg-12">
  <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
    <div class="content">

      {{-- Test sarlavha ma'lumotlari --}}
      <div class="section-title mb-3">
        <h4 class="rbt-title-style-3">
          {{ data_get($test, 'chapter.subject.name') }} — {{ data_get($test, 'chapter.name') }}
        </h4>
        {!! data_get($test, 'chapter.info') !!}
      </div>

      <div class="quize-top-meta d-flex justify-content-between align-items-center">
        <div class="quize-top-left">
          <span>Test ID: <strong>{{ data_get($test, 'test_id') }}</strong></span>
          <span class="ms-3">Savollar: <strong id="total-count"></strong></span>
        </div>
        <div class="quize-top-right">
          <span>Vaqt: <strong id="countdown">30:00</strong></span>
        </div>
      </div>

      <hr>

      {{-- Navigatsiya (raqamlar) --}}
      <nav>
        <div class="nav-links mb--20">
          <ul id="pager" class="rbt-pagination justify-content-start flex-wrap"></ul>
        </div>
      </nav>

      {{-- Savol konteyneri --}}
      <form id="quiz-form" class="quiz-form-wrapper">
        <input type="hidden" id="test_id" value="{{ data_get($test, 'test_id') }}">

        <div id="question-wrap" class="rbt-single-quiz"></div>

        <div class="d-flex justify-content-between mt-4">
          <button id="btn-prev" type="button" class="rbt-btn btn-outline-secondary">Oldingi</button>
          <div>
            <button id="btn-next" type="button" class="rbt-btn btn-gradient me-2">Keyingi</button>
            <button id="btn-submit" type="button" class="rbt-btn btn-primary">Yakunlash</button>
          </div>
        </div>
      </form>

      {{-- Submit uchun yashirin forma (serverga POST) --}}
      <form id="submit-form" method="POST" action="{{ route('user.test.submit') }}" class="d-none">
        @csrf
        <input type="hidden" name="test_id" value="{{ data_get($test, 'test_id') }}">
        <input type="hidden" name="answers" id="answers-input">
      </form>

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
  // Boshlang‘ich vaqt (179 minut 25 sekund)
  let totalSeconds = 179 * 60 + 25;

  function updateTimer() {
    // Soat, minut, sekund hisoblash
    const hours   = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const seconds = totalSeconds % 60;

    // Format: 2 xonali qilish uchun padStart ishlatyapmiz
    const formatted =
      String(hours).padStart(2, '0') + ":" +
      String(minutes).padStart(2, '0') + ":" +
      String(seconds).padStart(2, '0');

    // Ekranga chiqarish
    document.getElementById("countdown").textContent = formatted;

    // 1 soniyadan kamaytirish
    if (totalSeconds > 0) {
      totalSeconds--;
    } else {
      clearInterval(timer); // vaqt tugasa to‘xtatamiz
      // Hohlasa alert yoki boshqa action qilishingiz mumkin
      alert("Vaqt tugadi!");
    }
  }

  // Har 1 sekundda yangilash
  updateTimer(); // birinchi chaqirish
  const timer = setInterval(updateTimer, 1000);
</script>

<script>
// ----- 1) Ma'lumot -----
const TEST = @json($test ?? []);
const questions = TEST?.questions ?? [];
const total = questions.length;
document.getElementById('total-count').textContent = total;

// Javoblar: { [question_id]: option_id }
const answers = {}; 

// Current index (0-based)
let idx = 0;

// ----- 2) UI render -----
const wrap = document.getElementById('question-wrap');
const pager = document.getElementById('pager');
const btnPrev = document.getElementById('btn-prev');
const btnNext = document.getElementById('btn-next');
const btnSubmit = document.getElementById('btn-submit');

// Pager (raqamlar) hosil qilish
function buildPager() {
  pager.innerHTML = '';

  // Previous
  const liPrev = document.createElement('li');
  liPrev.innerHTML = `<a href="#" aria-label="Previous"><i class="feather-chevron-left"></i></a>`;
  liPrev.onclick = (e) => { e.preventDefault(); go(idx - 1); };
  pager.appendChild(liPrev);

  // Numbers
  for (let i = 0; i < total; i++) {
    const li = document.createElement('li');
    li.className = (i === idx) ? 'active' : '';
    li.innerHTML = `<a href="#">${i + 1}</a>`;
    li.onclick = (e) => { e.preventDefault(); go(i); };
    pager.appendChild(li);
  }

  // Next
  const liNext = document.createElement('li');
  liNext.innerHTML = `<a href="#" aria-label="Next"><i class="feather-chevron-right"></i></a>`;
  liNext.onclick = (e) => { e.preventDefault(); go(idx + 1); };
  pager.appendChild(liNext);
}

// Savol sahifasini chizish
function renderQuestion() {
  if (!questions[idx]) { wrap.innerHTML = '<p>—</p>'; return; }

  const q = questions[idx];
  const qNo = idx + 1;

  const saved = answers[q.id] ?? null;

  // instruction va question — HTML bo'lishi mumkin
  const html = `
    <h5>${qNo}. ${q.question || ''}</h5>
    ${q.instruction ? `<div class="mb-2">${q.instruction}</div>` : ''}
    <div class="row g-3 mt--10">
      ${q.options.map((opt, i) => {
        const inputId = `q${q.id}_opt${i}`;
        const checked = (saved && saved === opt.id) ? 'checked' : '';
        return `
          <div class="col-lg-12">
            <label class="rbt-checkbox-wrapper d-flex align-items-center">
              <input class="form-check-input me-2" type="radio" 
                     name="q_${q.id}" id="${inputId}" value="${opt.id}" ${checked}>
              <span>${opt.body}</span>
            </label>
          </div>
        `;
      }).join('')}
    </div>
  `;

  wrap.innerHTML = html;

  // radio change -> answers ga yozamiz
  const radios = wrap.querySelectorAll('input[type=radio]');
  radios.forEach(r => r.addEventListener('change', (e) => {
    answers[q.id] = e.target.value;
  }));

  // Tugmalar holati
  btnPrev.disabled = (idx === 0);
  btnNext.disabled = (idx === total - 1);
}

// Indexni o'zgartirish
function go(nextIdx) {
  if (nextIdx < 0 || nextIdx >= total) return;
  idx = nextIdx;
  buildPager();
  renderQuestion();
}

// Next/Prev
btnPrev.addEventListener('click', () => go(idx - 1));
btnNext.addEventListener('click', () => go(idx + 1));

// Submit
btnSubmit.addEventListener('click', () => {
  if (!confirm('Testni yakunlashni xohlaysizmi?')) return;

  // answers formatini API talabiga moslaymiz:
  // [{question_id: .., option_id: ..}, ...]
  const payload = Object.entries(answers).map(([qid, oid]) => ({
    question_id: parseInt(qid, 10),
    option_id: oid
  }));

  document.getElementById('answers-input').value = JSON.stringify(payload);
  document.getElementById('submit-form').submit();
});

// Boshlang'ich chizish
buildPager();
renderQuestion();

// ----- 3) Timer (oddiy 30 daqiqa) -----
let remain = 30 * 60; // 30 min
const cd = document.getElementById('countdown');
const timer = setInterval(() => {
  remain--;
  if (remain <= 0) {
    clearInterval(timer);
    cd.textContent = '00:00';
    alert('Vaqt tugadi. Javoblar yuboriladi.');
    btnSubmit.click();
    return;
  }
  const m = String(Math.floor(remain / 60)).padStart(2, '0');
  const s = String(remain % 60).padStart(2, '0');
  cd.textContent = `${m}:${s}`;
}, 1000);
</script>
@endsection
