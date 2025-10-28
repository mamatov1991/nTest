@extends('user.layout')

@section('main')
<div class="col-lg-9">
    <!-- Start Enrole Course  -->
    <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
        <div class="content">

            <div class="section-title">
                <h4 class="rbt-title-style-3">Sozlamalar</h4>
            </div>

            <div class="advance-tab-button mb--30">
                <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="myTab-4" role="tablist">
                    <li role="presentation">
                        <a href="#" class="tab-button active" id="home-tab-4" data-bs-toggle="tab" data-bs-target="#home-4" role="tab" aria-controls="home-4" aria-selected="true">
                            <span class="title">Ma’lumotlarni tahrirlash</span>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#" class="tab-button" id="profile-tab-4" data-bs-toggle="tab" data-bs-target="#profile-4" role="tab" aria-controls="profile-4" aria-selected="false">
                            <span class="title">Parolni o‘zgartirish</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                {{-- === Tab: Ma’lumotlarni tahrirlash === --}}
                <div class="tab-pane fade active show" id="home-4" role="tabpanel" aria-labelledby="home-tab-4">
                    <div class="row g-5 mb--30">
                        <h4 class="title text-center">Tahrirlash</h4>

                        <form action="{{ route('user.setting.post') }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf

                            {{-- Ism / Familya --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--10">
                                <div class="rbt-form-group">
                                    <input id="name" type="text" name="name" placeholder="Ism *"
                                           value="{{ old('name', $userData['name'] ?? '') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--10">
                                <div class="rbt-form-group">
                                    <input id="surname" type="text" name="surname" placeholder="Familya *"
                                           value="{{ old('surname', $userData['surname'] ?? '') }}" required>
                                </div>
                            </div>

                            {{-- Viloyat --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                                <div class="filter-select rbt-modern-select">
                                    <select id="region_id" name="region_id" class="w-100" required>
                                        <option disabled {{ old('region_id', $userData['region']['id'] ?? null) ? '' : 'selected' }}>
                                            Hudud (viloyat) *
                                        </option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region['id'] }}"
                                                {{ (string)old('region_id', $userData['region']['id'] ?? '') === (string)$region['id'] ? 'selected' : '' }}>
                                                {{ $region['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Tuman --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                                <div class="filter-select rbt-modern-select">
                                    <select id="district_id" name="district_id" class="w-100" required {{ empty($districts) ? 'disabled' : '' }}>
                                        <option disabled {{ old('district_id', $userData['district']['id'] ?? null) ? '' : 'selected' }}>
                                            Tuman yoki shahar *
                                        </option>
                                        @foreach($districts as $d)
                                            <option value="{{ $d['id'] }}"
                                                {{ (string)old('district_id', $userData['district']['id'] ?? '') === (string)$d['id'] ? 'selected' : '' }}>
                                                {{ $d['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Maktab --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--10">
                                <div class="rbt-form-group">
                                    <input id="school" type="text" name="school" placeholder="Maktab (yoki bitirgan maktabi) *"
                                           value="{{ old('school', $userData['school'] ?? '') }}" required>
                                </div>
                            </div>

                            {{-- Sinf --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                                <div class="filter-select rbt-modern-select">
                                    <select id="class_number" name="class_number" class="w-100" required>
                                        <option disabled {{ old('class_number', $userData['class_number'] ?? null) ? '' : 'selected' }}>Sinfi *</option>
                                        @for ($i = 1; $i <= 11; $i++)
                                            <option value="{{ $i }}"
                                                {{ (string)old('class_number', $userData['class_number'] ?? '') === (string)$i ? 'selected' : '' }}>
                                                {{ $i }}-sinf
                                            </option>
                                        @endfor
                                        <option value="graduate" {{ old('class_number', $userData['class_number'] ?? '') === 'graduate' ? 'selected' : '' }}>
                                            Bitirgan
                                        </option>
                                    </select>
                                </div>
                            </div>

                            {{-- Fanlar (multi-select) --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb--20">
                                <div class="filter-select rbt-modern-select">
                                    @php
                                        $selectedSubjectIds = collect(old('subjects', collect($userData['subjects'] ?? [])->pluck('id')->all()))
                                            ->map(fn($v)=>(string)$v)->all();
                                    @endphp
                                    <select class="w-100" id="subjects" name="subjects[]" data-live-search="true" title="Fanlar *"
                                            multiple data-size="7" data-actions-box="true" data-selected-text-format="count > 5" required>
                                        @foreach($subjects as $subj)
                                            <option value="{{ $subj['id'] }}"
                                                {{ in_array((string)$subj['id'], $selectedSubjectIds, true) ? 'selected' : '' }}>
                                                {{ $subj['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Til --}}
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb--20">
                                <div class="filter-select rbt-modern-select">
                                    <select id="language" name="language" class="w-100" required>
                                        <option disabled {{ old('language', $userData['language'] ?? null) ? '' : 'selected' }}>Test tili *</option>
                                        <option value="uz" {{ old('language', $userData['language'] ?? '') === 'uz' ? 'selected' : '' }}>O‘zbekcha</option>
                                        <option value="ru" {{ old('language', $userData['language'] ?? '') === 'ru' ? 'selected' : '' }}>Русский</option>
                                        <option value="en" {{ old('language', $userData['language'] ?? '') === 'en' ? 'selected' : '' }}>English</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="phone" value="{{ old('phone', $userData['phone'] ?? '') }}" required>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="rbt-form-group">
                                    <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse" style="float:right; margin-right:6px;">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Saqlash</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                {{-- === Tab: Parolni o‘zgartirish === --}}
                <div class="tab-pane fade" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                    <div class="row g-5 mb--30">
                        <h4 class="title text-center">Parolni o‘zgartirish</h4>

                        <form action="/user/setting" method="POST" class="rbt-profile-row rbt-default-form row row--15">
                            @csrf
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb--10">
                                <div class="rbt-form-group">
                                    <input type="password" placeholder="Oldingi parol *" name="old_password" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb--10">
                                <div class="rbt-form-group">
                                    <input type="password" placeholder="Yangi parol *" name="new_password" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb--10">
                                <div class="rbt-form-group">
                                    <input type="password" placeholder="Qaytadan yangi parol *" name="confirm_password" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="rbt-form-group">
                                    <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse" style="float: right; margin-right: 6px;">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Saqlash</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div> {{-- .tab-content --}}
        </div>
    </div>
    <!-- End Enrole Course  -->
</div>

<div class="rbt-separator-mid">
    <div class="container">
        <hr class="rbt-separator m-0">
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const region   = document.getElementById('region_id');
  const district = document.getElementById('district_id');
  const school   = document.getElementById('school_id');

  const API_BASE = 'https://api.ntest.uz/api'; // sizning API bazangiz
  const hasPicker = (typeof $ !== 'undefined' && $.fn.selectpicker);

  // Sahifa ochilgandagi old/userData qiymatlar
  const initialRegionId   = "{{ old('region_id', $userData['region']['id'] ?? '') }}";
  const initialDistrictId = "{{ old('district_id', $userData['district']['id'] ?? '') }}";
  const initialSchoolId   = "{{ old('school_id', $userData['school']['id'] ?? '') }}";

  function refresh(el){ if(hasPicker && el){ $(el).selectpicker('refresh'); } }
  function enable(el){ if(!el) return; el.disabled=false; if(hasPicker) $(el).prop('disabled',false).selectpicker('refresh'); }
  function disable(el){ if(!el) return; el.disabled=true; if(hasPicker) $(el).prop('disabled',true).selectpicker('refresh'); }

  function setOptions(el, items, placeholder, selected=null){
    if(!el) return;
    el.innerHTML = `<option disabled ${selected ? '' : 'selected'}>${placeholder}</option>`;
    (items||[]).forEach(it=>{
      const opt = document.createElement('option');
      opt.value = it.id;
      opt.textContent = it.name;
      if(selected && String(selected) === String(it.id)) opt.selected = true;
      el.appendChild(opt);
    });
    refresh(el);
  }

  async function loadDistricts(regionId, preselect=null){
    disable(district);
    setOptions(district, [], 'Yuklanmoqda...');
    if(school){ disable(school); setOptions(school, [], 'Maktabni tanlang *'); }

    try{
      const resp = await fetch(`${API_BASE}/school/districts/${encodeURIComponent(regionId)}`, {
        headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' }
      });
      if(!resp.ok) throw new Error(`HTTP ${resp.status}`);
      const payload = await resp.json();
      const list = payload.data ?? payload;
      setOptions(district, list, 'Tuman yoki shaharni tanlang *', preselect);
      enable(district);
      return list;
    }catch(e){
      console.error('districts error', e);
      setOptions(district, [], 'Xatolik yuz berdi');
      disable(district);
      return [];
    }
  }

  async function loadSchools(districtId, preselect=null){
    if(!school) return [];
    disable(school);
    setOptions(school, [], 'Yuklanmoqda...');
    try{
      const resp = await fetch(`${API_BASE}/school/schools/${encodeURIComponent(districtId)}`, {
        headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' }
      });
      if(!resp.ok) throw new Error(`HTTP ${resp.status}`);
      const payload = await resp.json();
      const list = payload.data ?? payload;
      setOptions(school, list, 'Maktabni tanlang *', preselect);
      enable(school);
      return list;
    }catch(e){
      console.error('schools error', e);
      setOptions(school, [], 'Xatolik yuz berdi');
      disable(school);
      return [];
    }
  }

  // selectpickerlarni bir marta init (agar kerak bo'lsa)
  if(hasPicker){ $('#region_id,#district_id,#school_id,#subjects,#language').selectpicker(); }

  // Viloyat o'zgarsa → tumanlarni yukla
  if(region && district){
    region.addEventListener('change', async function(){
      const rId = this.value;
      await loadDistricts(rId, null);
    });
  }

  // Tuman o'zgarsa → maktablarni yukla
  if(district && school){
    district.addEventListener('change', async function(){
      const dId = this.value;
      await loadSchools(dId, null);
    });
  }

  // Sahifa ochilganda mavjud tanlovlarni tiklash
  (async function init(){
    if(initialRegionId){
      await loadDistricts(initialRegionId, initialDistrictId || null);
      const dId = district.value || initialDistrictId;
      if(dId && school){
        await loadSchools(dId, initialSchoolId || null);
      }
    } else {
      setOptions(district, [], 'Tuman yoki shahar *');
      disable(district);
      if(school){ setOptions(school, [], 'Maktabni tanlang *'); disable(school); }
    }
  })();
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
