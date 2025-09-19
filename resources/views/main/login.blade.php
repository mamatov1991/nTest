@extends('main.layout')

@section('index')
 <div class="rbt-elements-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row gy-5 row--30">

                <div class="col-lg-6 offset-lg-3">
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                        <h3 class="title text-center">Tizimga kirish</h3>
                        <form class="max-width-auto" action="{{ route('login.post') }}" method="POST">
    @csrf

    <div class="form-group">
        <input id="phone" name="phone" type="tel"
               inputmode="numeric" autocomplete="tel"
               maxlength="13"
               pattern="^\+998\d{9}$" title="Format: +998XXXXXXXXX" required />
        <label>Telefon raqam *</label>
        <span class="focus-border"></span>
        @error('login') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <input name="password" type="password" required>
        <label>Parol *</label>
        <span class="focus-border"></span>
    </div>

    <div class="row mb--30">
        <div class="col-lg-6">
            <div class="rbt-checkbox">
                <input type="checkbox" id="rememberme" name="rememberme">
                <label for="rememberme">Eslab qolish</label>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="rbt-lost-password text-end">
                <a class="rbt-btn-link" href="/reset-send-sms">Parolni tiklash</a>
            </div>
        </div>
    </div>

    <div class="form-submit-group">
        <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
            <span class="icon-reverse-wrapper">
                <span class="btn-text">Kirish</span>
                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
            </span>
        </button>
    </div>
</form>
                        <p class="text-center mt--30">Agar platformadan ilk marotaba foydalanayotgan bo‘lsangiz <a href="/registration" style="color: rgb(6, 53, 209); font-weight: 500;">ro‘yxatdan o‘ting</a>.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>
@endsection

@section('add-script')
 <script>
  const phone = document.getElementById('phone');

  // Foydalanuvchi inputni bosganda (+998 avtomatik chiqsin)
  phone.addEventListener('focus', () => {
    if (phone.value.trim() === '') {
      phone.value = '+998';
      // kursorni oxiriga qo'yamiz
      setTimeout(() => phone.setSelectionRange(phone.value.length, phone.value.length), 0);
    }
  });

  // Agar foydalanuvchi hech narsa yozmagan bo‘lsa, chiqib ketganda tozalansin
  phone.addEventListener('blur', () => {
    if (phone.value === '+998') {
      phone.value = '';
    }
  });

  // Faqat ruxsat etilgan belgilarni qoldiramiz (+ va raqamlar), +998 prefiksini majburiy qilamiz
  phone.addEventListener('input', () => {
    let v = phone.value;

    // Faqat raqam va '+' qoldir
    v = v.replace(/[^\d+]/g, '');

    // Bitta '+' boshida bo'lsin xolos
    v = v.replace(/\+/g, '');
    v = '+' + v;

    // Majburiy prefiks: +998
    if (!v.startsWith('+998')) {
      v = '+998' + v.replace(/^\+?/, '').replace(/^998?/, '');
    }

    // Uzunlikni cheklash: +998 (4 belgi) + 9 raqam = 13
    v = v.slice(0, 13);

    phone.value = v;

    // Brauzer validatsiyasi uchun custom xabar
    phone.setCustomValidity(/^\+998\d{9}$/.test(v) ? '' : 'Format: +998XXXXXXXXX');
  });

  // Foydalanuvchi +998ni o'chira olmasin
  phone.addEventListener('keydown', (e) => {
    const start = phone.selectionStart;
    if ((e.key === 'Backspace' && start <= 4) || (e.key === 'Delete' && start < 4)) {
      e.preventDefault();
    }
  });

  // Paste qilinganda ham qoidalar ishlasin
  phone.addEventListener('paste', (e) => {
    e.preventDefault();
    const text = (e.clipboardData || window.clipboardData).getData('text');
    const digits = text.replace(/\D/g, '').replace(/^998?/, '');
    phone.value = ('+998' + digits).slice(0, 13);
    phone.dispatchEvent(new Event('input'));
  });
</script>


@endsection