@extends('user.layout')

@section('main')
<div class="col-lg-9">
                            <!-- Start Enrole Course  -->
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                                <div class="content">

                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">Reyting</h4>
                                    </div>

                                    <div class="advance-tab-button mb--30">
                                        <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="myTab-4" role="tablist">
                                          @foreach($userData['subjects'] as $subject)
                                            <li role="presentation">
                                                <a href="#" class="tab-button @if($loop->first) active @endif" id="home-tab-{{$loop->index}}" data-bs-toggle="tab" data-bs-target="#home-{{$loop->index}}" role="tab" aria-controls="home-{{$loop->index}}" aria-selected="true">
                                                    <span class="title">{{$subject['name']}}</span>
                                                </a>
                                            </li>
                                          @endforeach
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        @foreach($userData['subjects'] as $subject)
                                        <div class="tab-pane fade @if($loop->first) active show @endif" id="home-{{$loop->index}}" role="tabpanel" aria-labelledby="home-tab-{{$loop->index}}">
                                            <div class="row g-5 mb--30">
                                                <div class="chart-wrap">
                                                  <p class="text-center mt-5">Jarayonda...</p>
    <!-- <canvas id="rankChart"></canvas> -->
  </div>
                                    </div>
                                            </div>
@endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- End Enrole Course  -->
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
    // -------- 1) Kiruvchi ma'lumotlar (o'zingizniki bilan almashtiring) --------
    const variants = ["1-variant", "2-variant", "3-variant", "4-variant"];

    // Sizning ballaringiz (har variant uchun)
    const myScores = {
      "1-variant": 89,
      "2-variant": 78,
      "3-variant": 84,
      "4-variant": 91
    };

    // Guruhdagi (masalan 150 kishi) balllar: har bir variant uchun massiv.
    // >>> Eslatma: bu yerga backenddan kelgan ro‘yxatni qo‘ying. Demo uchun random to‘ldirib turibmiz.
    const groupSize = 150;
    const groupScores = {};
    variants.forEach(v => {
      // Demo: 60–100 oralig‘ida soxta balllar generatsiyasi
      const arr = Array.from({length: groupSize - 1}, () => Math.floor(60 + Math.random() * 41));
      // Sizning balingizni ham ro‘yxatga qo‘shamiz (bor bo‘lsin)
      arr.push(myScores[v]);
      groupScores[v] = arr;
    });

    // -------- 2) Rank hisoblash funksiyasi --------
    // "competition" rank: sizdan baland balllar soni + 1
    // "dense" rank: noyob yuqori balllar soni + 1 (xohlasangiz shuni yoqing)
    const RANK_METHOD = "competition"; // "competition" | "dense"

    function getRankAmong(scoresArray, myScore, method = RANK_METHOD) {
      if (!Array.isArray(scoresArray) || typeof myScore !== "number") return null;
      // Katta -> kichik sort
      const sorted = [...scoresArray].sort((a, b) => b - a);

      if (method === "dense") {
        const uniqueDesc = [...new Set(sorted)];
        return uniqueDesc.findIndex(s => s <= myScore) + 1;
      } else {
        // competition rank
        const higherCount = sorted.filter(s => s > myScore).length;
        return higherCount + 1;
      }
    }

    // Har bir variant uchun sizning rankingizni hisoblaymiz
    const myRanks = variants.map(v => getRankAmong(groupScores[v], myScores[v]));

    // -------- 3) Grafik --------
    const ctx = document.getElementById("rankChart").getContext("2d");
    new Chart(ctx, {
      type: "line",
      data: {
        labels: variants,
        datasets: [{
          label: "Mening o‘rnim",
          data: myRanks,
          tension: 0.3,
          pointRadius: 5,
          pointHoverRadius: 7,
          borderWidth: 2,
          fill: false
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            display: true,
            text: "",
            font: { size: 16 }
          },
          tooltip: {
            enabled: true,
            callbacks: {
              // Tooltip: "1-variant — O‘rin: 7 / 150 (Ball: 89)"
              label: (ctx) => {
                const v = ctx.label;
                const rank = ctx.parsed.y;
                const score = myScores[v];
                const total = groupScores[v]?.length || 0;
                return `${v} — O‘rin: ${rank} / ${total} (Ball: ${score})`;
              }
            }
          },
          legend: {
            position: "top",
            labels: {
              font: { size: 16, weight: "600" }
            }
          }
        },
        scales: {
          y: {
            // 1-o‘rin tepada bo‘lishi uchun teskari
            reverse: true,
            min: 1,
            // max qiymatni eng katta guruh hajmiga moslash
            suggestedMax: Math.max(...Object.values(groupScores).map(a => a.length)),
            title: { display: true, text: "" },
            ticks: { stepSize: 1, font: { size: 16 } }
          },
          x: {
            title: { display: true, text: "" },
            ticks: { font: { size: 16 } }
          }
        },
        interaction: { mode: "nearest", intersect: false },
        elements: { line: { borderWidth: 2 } }
      }
    });
  </script>

@endsection