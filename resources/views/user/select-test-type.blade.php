@extends('user.sub-layout')

@section('main')
<div class="col-lg-9">
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
                                <div class="content">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">
                                          <?php
                                          $testType = null;
                                          $chapterId = null;                                        
                                        ?>
                                        {{ $subjectName ?? 'Nomaʼlum fan' }}
                                         </h4>
                                    </div>
                                    <div class="row g-5 mb--30">
                        <h4 class="title text-center">Quyidagilarni tanlang</h4>
                        <form action="/user/select-test-type/{{ $subjectId }}" method="POST" class="rbt-profile-row rbt-default-form row row--15">
    @csrf

    <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb--20">
        <div class="filter-select rbt-modern-select">
            <select id="testCategory" name="testCategory" class="w-100 selectpicker">
                <option selected disabled>Test turini tanlang *</option>
                @foreach ($test_types as $types)
                    <option value="{{ $types['id'] }}">{{ $types['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb--20">
        <div class="filter-select rbt-modern-select">
            <select id="testType" name="testType" class="w-100 selectpicker">
                <option value=""  {{ !$testType ? 'selected' : '' }} disabled>Yakuniy yoki bo‘limlar *</option>
                <option value="yakuniy" {{ $testType === 'yakuniy' ? 'selected' : '' }}>Yakuniy test</option>
                <option value="bolim" {{ $testType === 'bolim' ? 'selected' : '' }}>Bo‘limlar bo‘yicha test</option>
            </select>
        </div>
    </div>

    <div id="childSelectWrap" class="col-lg-4 col-md-4 col-sm-4 col-12 mb--20 {{ $testType === 'bolim' ? '' : 'd-none' }}">
        <div class="filter-select rbt-modern-select">
            <select id="childSelect_chapter" name="chapterId" class="w-100 selectpicker">
                <option selected disabled>Bo‘limni tanlang *</option>
                @if (!empty($chapters))
                @foreach ($chapters as $chapter)
                    <option value="{{ $chapter['id'] }}" {{ ($chapterId ?? null) == $chapter['id'] ? 'selected' : '' }}>{{ $chapter['name'] }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div id="childSelectWrap1" class="col-lg-4 col-md-4 col-sm-4 col-12 mb--20 {{ $testType === 'yakuniy' ? '' : 'd-none' }}">
        <div class="filter-select rbt-modern-select ">
            <select id="childSelect_final_test" name="finalTestId" class="w-100 selectpicker">
                <option selected disabled>Variantni tanlang *</option>
                @if (!empty($final_tests))
                @foreach ($final_tests as $final_test)
                    <option value="{{ $final_test['id'] }}" {{ ($finalTestId ?? null) == $final_test['id'] ? 'selected' : '' }}>{{ $final_test['name'] }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
<input type="hidden" name="subjectId" value="{{ $subjectId }}">
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

    // testCategory o‘zgarganda AJAX orqali chapters va final_tests ni olib kelamiz
    $('#testCategory').on('changed.bs.select', function () {
        let testCategory = $(this).val();
        let subjectId = "{{ $subjectId }}";

        $.ajax({
            url: `/user/tests-by-category/${subjectId}`,
            method: 'GET',
            data: { testCategory: testCategory },
            success: function (response) {
                // Chapters select tozalash va yangilash
                let $chapterSelect = $('#childSelect_chapter');
                $chapterSelect.empty().append('<option disabled selected>Bo‘limni tanlang *</option>');
                response.chapters.forEach(ch => {
                    $chapterSelect.append(`<option value="${ch.id}">${ch.name}</option>`);
                });
                $chapterSelect.selectpicker('refresh');

                // Final tests select tozalash va yangilash
                let $finalSelect = $('#childSelect_final_test');
                $finalSelect.empty().append('<option disabled selected>Variantni tanlang *</option>');
                response.final_tests.forEach(ft => {
                    $finalSelect.append(`<option value="${ft.id}">${ft.name}</option>`);
                });
                $finalSelect.selectpicker('refresh');
            }
        });
    });

    // testType bo‘yicha select ko‘rinishini boshqarish
    $('#testType').on('changed.bs.select', function () {
        let val = $(this).val();
        if (val === 'bolim') {
            $('#childSelect_chapter').closest('.col-lg-4').removeClass('d-none');
            $('#childSelect_final_test').closest('.col-lg-4').addClass('d-none');
        } else if (val === 'yakuniy') {
            $('#childSelect_final_test').closest('.col-lg-4').removeClass('d-none');
            $('#childSelect_chapter').closest('.col-lg-4').addClass('d-none');
        } else {
            $('#childSelect_chapter').closest('.col-lg-4').addClass('d-none');
            $('#childSelect_final_test').closest('.col-lg-4').addClass('d-none');
        }
    });
});
</script>


@endsection
