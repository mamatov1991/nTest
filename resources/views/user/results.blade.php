@extends('user.layout')

@section('main')
<div class="col-lg-9">
    <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
        <div class="content">
            <div class="section-title">
                <h4 class="rbt-title-style-3">Natijalar</h4>
            </div>
            <div class="rbt-dashboard-table table-responsive mobile-table-750">
                <table class="rbt-table table table-borderless">
                    <thead>
                        <tr>
                            <th>T/r</th>
                            <th>Fanlar</th>
                            <th>Variantlar</th>
                            <th>Test</th>
                            <th>Yozma ish</th>
                            <th>Umumiy ball</th>
                            <th>Daraja</th>
                            <th>Sana</th>
                            <th>
                                Tavsiyalar
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($final_test_result_data as $index => $test)
                            @php
                                $details = collect($test['details'] ?? []);
                                $totalQuestions = $details->count();
                                $correctAnswers = $details->where('is_correct', '1')->count();
                                $allTestScore = $test['score']; 
                                $writtenDetails = $details->whereIn('testable_type', ['esse']);
                                $writtenScore = $writtenDetails->where('is_correct', '1')->count();
                                $testScore = $allTestScore-$writtenScore;
                                $overallScore = $allTestScore / 2;

                                $level = '-';

                                if ($test['is_marked'] == 1) {
                                    if ($overallScore >= 70 && $overallScore <= 76) {
                                        $level = 'A+';
                                    } elseif ($overallScore >= 65 && $overallScore < 70) {
                                        $level = 'A';
                                    } elseif ($overallScore >= 60 && $overallScore < 65) {
                                        $level = 'B+';
                                    } elseif ($overallScore >= 55 && $overallScore < 60) {
                                        $level = 'B';
                                    } elseif ($overallScore >= 50 && $overallScore < 55) {
                                        $level = 'C+';
                                    } elseif ($overallScore < 50) {
                                        $level = 'C';
                                    }
                                }

                                $comments = $details
                                ->where('is_correct', '0')
                                ->pluck('comment')
                                ->filter()
                                ->unique(function ($comment) {
                                // har bir kommentni mazmuniga qarab yagona qilish
                                return trim(mb_strtolower(strip_tags($comment)));
                                })
                                ->values()
                                ->toArray();

                                $commentsHtml = collect($comments)
                                ->map(fn($comment) => "<p class='mb--10'>{$comment}</p>")
                                ->implode('');

                                $commentsHtml = $commentsHtml ?: '<p class="mb--10">Tavsiyalar mavjud emas.</p>';

                                $date = $test['finished_at'] ?? 'N/A';
                                $formattedDate = $date !== 'N/A' ? date('d.m.Y', strtotime($date)) : 'N/A';
                            @endphp


                            <tr data-test-id="{{ $test['id'] }}"
                                data-fan="{{ e(data_get($test, 'final_test.subject.name', 'Noma\'lum fan')) }}"
                                data-variant="{{ e(data_get($test, 'final_test.name', 'Noma\'lum variant')) }}"
                                data-comments='@json($commentsHtml)'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ data_get($test, 'final_test.subject.name', 'Noma\'lum fan') }}</td>
                                <td>{{ data_get($test, 'final_test.name', 'Noma\'lum variant') }}</td>
                                <td>{{ $testScore }}</td>
                                <td>{{ $writtenScore }}</td>
                                <td>{{ $overallScore }}</td>
                                <td>{{ $level }}</td>
                                <td>{{ $formattedDate }}</td>
                                <td>
                                @if($test['is_marked'] == 1)
                                <a href="#" class="rbt-btn btn-xs bg-primary-opacity radius-round tavsiya-btn" title="Tavsiya" role="button">
                                <i class="feather-eye pl--0" style="top: 5px;"></i>
                                </a>
                                @else
                                <p style="color: rgba(252, 252, 252, 1); font-size: 14px; text-align: center; text-indent: 0px!important; background-color: #eb9e10ff; padding: 5px; border-radius: 5px;">
                                Test tekshirish jarayonida
                                </p>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(empty($test))
                            <p class="text-center">Natija mavjud emas.</p>
@endif
            </div>

            {{-- Pagination --}}
            <div class="row">
                @if ($final_test_result_data->hasPages())
                    <div class="col-lg-12 mt--40">
                        <nav>
                            <ul class="rbt-pagination">
                                {{-- Previous --}}
                                @if ($final_test_result_data->onFirstPage())
                                    <li class="disabled"><span><i class="feather-chevron-left"></i></span></li>
                                @else
                                    <li><a href="{{ $final_test_result_data->previousPageUrl() }}"><i class="feather-chevron-left"></i></a></li>
                                @endif

                                {{-- Pages --}}
                                @foreach ($final_test_result_data->getUrlRange(1, $final_test_result_data->lastPage()) as $page => $url)
                                    @if ($page == $final_test_result_data->currentPage())
                                        <li class="active"><a href="#">{{ $page }}</a></li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next --}}
                                @if ($final_test_result_data->hasMorePages())
                                    <li><a href="{{ $final_test_result_data->nextPageUrl() }}"><i class="feather-chevron-right"></i></a></li>
                                @else
                                    <li class="disabled"><span><i class="feather-chevron-right"></i></span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const tavsiyaBtns = document.querySelectorAll('.tavsiya-btn');

  tavsiyaBtns.forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();

      const row = this.closest('tr');
      if (!row) return;

      const fan = row.dataset.fan || 'Nomaʼlum fan';
      const variant = row.dataset.variant || '-';
      let commentsHtml = '';
      try {
        commentsHtml = JSON.parse(row.dataset.comments || '""') || '';
      } catch {
        commentsHtml = row.dataset.comments || '';
      }
      if (!commentsHtml) commentsHtml = '<p class="mb--10">Tavsiyalar mavjud emas.</p>';

      Swal.fire({
        title: `<strong>${fan}</strong> — Tavsiyalar`,
        html: `
          <div style="text-align:justify; font-size:16px; line-height:1.6;">
            <p><strong>${fan}</strong> fanidan <strong>${variant}</strong> bo‘yicha tavsiyalar:</p>
            <div style="margin-top:10px;">${commentsHtml}</div>
            <p style="margin-top:25px; color:#333; font-style:italic; font-weight:600;">
              Sizning kelgusi ishlaringizda muvaffaqiyat tilaymiz!
            </p>
          </div>
        `,
        icon: 'info',
        width: '700px',
        confirmButtonText: 'Yopish',
        confirmButtonColor: '#0055c6',
        showCloseButton: true
      });
    });
  });
});
</script>



@endsection
