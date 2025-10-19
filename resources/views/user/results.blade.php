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
                            <th>Tavsiyalar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($final_test_result_data as $index => $test)
                            @php
                                $details = collect($test['details'] ?? []);
                                $totalQuestions = $details->count();
                                $correctAnswers = $details->where('is_correct', '1')->count();
                                $testScore = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 0) : 0; 

                                $writtenDetails = $details->whereIn('testable_type', ['esse', 'double_fill_gap']);
                                $writtenScore = $writtenDetails->where('is_correct', '1')->count(); 
                                $overallScore = $totalQuestions > 0 ? round((($correctAnswers + $writtenScore) / ($totalQuestions + $writtenDetails->count())) * 100, 0) : 0;

                                $level = 'A1';
                                if ($overallScore >= 57 && $overallScore <= 65) $level = 'A2';
                                elseif ($overallScore >= 66 && $overallScore <= 75) $level = 'B1';
                                elseif ($overallScore >= 76 && $overallScore <= 85) $level = 'B2';
                                elseif ($overallScore > 85) $level = 'C';

                                $comments = $details->where('is_correct', '0')->pluck('comment')->filter()->values()->toArray();
                                $commentsHtml = collect($comments)->map(fn($comment) => "<p class='mb--10'>{$comment}</p>")->implode('');
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
                                    <a class="rbt-btn btn-xs bg-primary-opacity radius-round tavsiya-btn"
                                       href="#" title="Tavsiya" role="button"
                                       data-bs-toggle="modal" data-bs-target="#tavsiyaModal">
                                        <i class="feather-eye pl--0"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

{{-- Modal --}}
<div class="rbt-team-modal modal fade rbt-modal-default" id="tavsiyaModal" tabindex="-1" aria-labelledby="tavsiyaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tavsiyalar</h5>
                <button type="button" class="rbt-round-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="feather-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-content" class="mb--20" style="font-size:16px!important;"></div>
                <div id="modal-comments"></div>
                <p class="mt--40" style="color:#333; font-style:italic; font-size:16px; font-weight:600;">
                    Sizning kelgusi ishlaringizda muvaffaqiyat tilaymiz!
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('tavsiyaModal');
    const modalContent = document.getElementById('modal-content');
    const modalComments = document.getElementById('modal-comments');
    const tavsiyaBtns = document.querySelectorAll('.tavsiya-btn');

    // Modal instance bitta marta yaratiladi
    const modalInstance = new bootstrap.Modal(modalEl, {
        backdrop: true,
        keyboard: true
    });

    tavsiyaBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const row = this.closest('tr');
            if (!row) return;

            const fan = row.dataset.fan;
            const variant = row.dataset.variant;
            const commentsHtml = JSON.parse(row.dataset.comments || '""');

            modalContent.innerHTML = `<strong>${fan}</strong> fanidan <strong>${variant}</strong> bo‘yicha tavsiyalar:`;
            modalComments.innerHTML = commentsHtml;

            // Modalni ko‘rsatamiz
            modalInstance.show();
        });
    });

    // Modal yopilganda kontentni tozalash
    modalEl.addEventListener('hidden.bs.modal', function () {
        modalContent.innerHTML = '';
        modalComments.innerHTML = '';
    });
});
</script>
@endsection
