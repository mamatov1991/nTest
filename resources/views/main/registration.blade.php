@extends('main.layout')

@section('index')
 <div class="rbt-elements-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row gy-5 row--30">
                <div class="col-lg-8 offset-lg-2">
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                        <h3 class="title text-center">Ro‘yxatdan o‘tish</h3>
                        <form action="{{ route('registration.student') }}" method="POST" class="rbt-profile-row rbt-default-form row row--15 mt--40">
                        @csrf
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--10">
                        <div class="rbt-form-group">
                        <input id="name" type="text" name="name" placeholder="Ism *" required>
                        </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--10">
                        <div class="rbt-form-group">
                        <input id="surname" type="text" name="surname" placeholder="Familya *" required>
                        </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                        <div class="filter-select rbt-modern-select">
                        <select id="region_id" name="region_id" class="w-100" required>
                        <option selected disabled>Hudud (viloyat) *</option>
                        @foreach($regions as $region)
                        <option value="{{ $region['id'] }}">{{ $region['name'] }}</option>
                        @endforeach
                        </select>
                        </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                        <div class="filter-select rbt-modern-select">
                        <select id="district_id" name="district_id" class="w-100" required disabled>
                        <option selected disabled>Tuman yoki shahar *</option>
                        </select>
                        </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--10">
                        <div class="rbt-form-group">
                        <input id="school" type="text" name="school" placeholder="Maktab (yoki bitirgan maktabi) *" required>
                        </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                        <div class="filter-select rbt-modern-select">
                        <select id="class_number" name="class_number" class="w-100">
                        <option selected disabled>Sinfi *</option>
                        @for ($i = 1; $i <= 11; $i++)
                        <option value="{{ $i }}">{{ $i }}-sinf</option>
                        @endfor
                        <option value="graduate">Bitirgan</option>
                        </select>
                        </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb--20">
                        <div class="filter-select rbt-modern-select">
                        <select class="w-100" id="subjects" name="subjects[]" data-live-search="true" title="Fanlar *" multiple data-size="7" data-actions-box="true" data-selected-text-format="count > 5">
                        @foreach($subjects as $subject)
                        <option value="{{ $subject['id'] }}">{{ $subject['name'] }}</option>
                        @endforeach
                        </select>
                        </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                        <div class="filter-select rbt-modern-select">
                        <select id="language" name="language" class="w-100">
                        <option selected disabled>Test tili *</option>
                        <option value="uz">O‘zbekcha</option>
                        <option value="ru">Русский</option>
                        </select>
                        </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="rbt-form-group">
                        <input id="phone" name="phone" type="tel" inputmode="numeric" autocomplete="tel" maxlength="13" pattern="^\+998\d{9}$" title="Format: +998XXXXXXXXX" placeholder="Telefon raqam *" required />
                        </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--10">
                        <div class="rbt-form-group">
                        <input id="password" type="password" name="password" placeholder="Parol *" required>
                        </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--10">
                        <div class="rbt-form-group">
                        <input id="password_confirmation" type="password" placeholder="Qaytadan parol *" required>
                        </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="rbt-checkbox">
                        <input type="checkbox" id="rememberme" name="rememberme" required>
                        <label for="rememberme">Barchasini to‘liq va to‘g‘ri to‘ldirdim</label>
                        </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="rbt-form-group">
                        <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse" style="float: right; margin-right: 6px;">
                        <span class="icon-reverse-wrapper">
                        <span class="btn-text">Ro‘yxatdan o‘tish</span>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
  const region   = document.getElementById('region_id');
  const district = document.getElementById('district_id');
  const school   = document.getElementById('school_id'); 

  // Elementlar mavjudligini tekshirish
  if (!region || !district) {
    console.error('Hudud topilmadi!');
    return;
  }

  // Bootstrap Selectni dastlabki holatda ishga tushirish
  if (typeof $ !== 'undefined' && $.fn.selectpicker) {
    $(district).selectpicker();
    if (school) $(school).selectpicker(); 
  }

  function resetDistrict(text = 'Tuman yoki shahar *') {
    if (typeof $ !== 'undefined' && $.fn.selectpicker) {
      $(district).selectpicker('destroy');
    }
    district.innerHTML = `<option disabled selected>${text}</option>`;
    if (typeof $ !== 'undefined' && $.fn.selectpicker) {
      $(district).selectpicker();
    }
  }

  function resetSchool(text = 'Maktabni tanlang *') { 
    if (!school) return;
    if (typeof $ !== 'undefined' && $.fn.selectpicker) {
      $(school).selectpicker('destroy');
    }
    school.innerHTML = `<option disabled selected>${text}</option>`;
    if (typeof $ !== 'undefined' && $.fn.selectpicker) {
      $(school).selectpicker();
    }
  }

  // Dastlabki holat
  resetDistrict();
  district.disabled = true;
  if (school) {
    resetSchool();
    school.disabled = true;
  }

  // Viloyat o'zgarganda — tumanlarni yuklash
  region.addEventListener('change', async function () {
    const id = this.value;
    resetDistrict('Yuklanmoqda...');
    district.disabled = true;

    try {
      const url = `{{ url('/registration') }}?region_id=${encodeURIComponent(id)}`;
      const resp = await fetch(url, {
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      if (!resp.ok) throw new Error(`HTTP error! status: ${resp.status}`);

      const payload = await resp.json();

      if (typeof $ !== 'undefined' && $.fn.selectpicker) {
        $(district).selectpicker('destroy');
      }

      district.innerHTML = '<option disabled selected>Tuman yoki shaharni tanlang *</option>';

      if (Array.isArray(payload) && payload.length > 0) {
        payload.forEach(item => {
          const opt = document.createElement('option');
          opt.value = item.id;
          opt.textContent = item.name;
          district.appendChild(opt);
        });
        district.disabled = false;
      } else {
        resetDistrict('Tuman yoki shahar topilmadi');
        district.disabled = true;
        return;
      }

      if (typeof $ !== 'undefined' && $.fn.selectpicker) {
        $(district).selectpicker();
      }

    } catch (e) {
      console.error('Error fetching districts:', e);
      resetDistrict('Xatolik yuz berdi');
      district.disabled = true;
    }
  });

  if (district && school) {
  district.addEventListener('change', async function () {
    const districtId = this.value;

    if (!districtId) {
      resetSchool('Tuman tanlang');
      school.disabled = true;
      return;
    }

    resetSchool('Yuklanmoqda...');
    school.disabled = true;

    try {
      const url = `https://api.ntest.uz/api/school/schools/${encodeURIComponent(districtId)}`;

      const resp = await fetch(url, {
        method: 'GET',
        mode: 'cors',
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      if (!resp.ok) throw new Error(`HTTP ${resp.status}: ${resp.statusText}`);

      const payload = await resp.json();

      const schools = payload.data || payload;

      if (typeof $ !== 'undefined' && $.fn.selectpicker) {
        $(school).selectpicker('destroy');
      }

      school.innerHTML = '<option disabled selected>Maktabni tanlang *</option>';

      if (Array.isArray(schools) && schools.length > 0) {
        schools.forEach(item => {
          const opt = document.createElement('option');
          opt.value = item.id;
          opt.textContent = item.name;
          school.appendChild(opt);
        });
        school.disabled = false;
      } else {
        resetSchool('Maktablar topilmadi');
        school.disabled = true;
        return;
      }

      if (typeof $ !== 'undefined' && $.fn.selectpicker) {
        $(school).selectpicker();
      }

    } catch (e) {
      console.error('Error fetching schools:', e);
      resetSchool('Xatolik: ' + (e.message || 'Server bilan bog\'lanishda xatolik'));
      school.disabled = true;
    }
  });
}
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
        Swal.fire({
            title: 'Muvaffaqiyatli!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            title: 'Xatolik!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK',
            timer: 5000,
            timerProgressBar: true,
            showConfirmButton: true
        });
    @endif
});
</script>

@endsection