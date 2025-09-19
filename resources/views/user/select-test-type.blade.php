@extends('user.layout')

@section('main')
<div class="col-lg-9">
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
                                <div class="content">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">Ona tili va adabiyot</h4>
                                    </div>
                                    <div class="row g-5 mb--30">
                        <h4 class="title text-center">Quyidagilarni tanlang</h4>
                        <form action="#" class="rbt-profile-row rbt-default-form row row--15">
    <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb--20">
    <div class="filter-select rbt-modern-select">
    <select class="w-100">
    <option selected disabled>Imtihon turini tanlang *</option>
    <option>Milliy sertifikat</option>
    <option>Attestatsiya</option>
    <option>CHSB</option>
    </select>
    </div>
    </div>                                            
                                                
  <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb--20">
  <div class="filter-select rbt-modern-select">
    <select id="displayname" class="w-100">
      <option selected disabled>Test turini tanlang *</option>
      <option value="yakuniy">Yakuniy test</option>
      <option value="bolim">Bo‘limlar bo‘yicha test</option>
    </select>
  </div>
</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb--20">
  <div id="childSelectWrap" class="filter-select rbt-modern-select d-none">
    <select id="childSelect" class="w-100">
      <!-- JS orqali to‘ldiriladi -->
    </select>
  </div>
</div>
                                                
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt--30">
                                                  <div class="rbt-form-group">
                                <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse" style="float: right; margin-right: 6px;">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Testni boshlash</span>
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
$(function () {
  $('.selectpicker').selectpicker({
    noneSelectedText: 'Tanlanmagan'
  });

  const optionsMap = {
    yakuniy: ['1-variant', '2-variant', '3-variant'],
    bolim:   ["1-bo'lim", "2-bo'lim", "3-bo'lim"]
  };

  function populateChild(list, placeholder) {
    const $child = $('#childSelect');
    $child.empty(); // tozalash

    // placeholder title yangilash (bootstrap-select shuni o‘qiydi)
    $child.attr('title', placeholder || 'Tanlang *');

    // optionlarni qo‘shish
    list.forEach(t => {
      $child.append(new Option(t, t));
    });

    // UI ni yangilash
    $child.selectpicker('refresh');
  }

  $('#displayname').on('changed.bs.select', function () {
    const val = $(this).val();

    if (val === 'yakuniy') {
      populateChild(optionsMap.yakuniy, 'Variantni tanlang *');
      $('#childSelectWrap').removeClass('d-none');
    } else if (val === 'bolim') {
      populateChild(optionsMap.bolim, "Bo'limni tanlang *");
      $('#childSelectWrap').removeClass('d-none');
    } else {
      $('#childSelectWrap').addClass('d-none');
      $('#childSelect').empty().selectpicker('refresh');
    }
  });
});
</script>

@endsection
