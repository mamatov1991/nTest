@extends('user.layout')

@section('main')
<div class="col-lg-9">
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
                                <div class="content">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">Asosiy</h4>
                                    </div>
                                    <div class="row g-5">

                                               
                                                @foreach($userData['subjects'] as $subject)
                                                 <!-- Start Single Subject  -->
                                                <div class="col-lg-4 col-md-6 col-12">
                                                    <div class="rbt-card variation-01 rbt-hover">
                                                        
                                                        <div class="rbt-card-body">
                                                           
                                                            <h4 class="rbt-card-title"><a href="/user/select-test-type/{{ $subject['id'] }}">{{$subject['name']}}</a>
                                                            </h4>
                                                            <div class="rbt-card-bottom">
                                                                <a class="rbt-btn btn-sm bg-primary-opacity w-100 text-center" href="/user/select-test-type/{{ $subject['id'] }}">Test ishlash</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Single Subject  -->
                                                @endforeach
<h4 class="text-center" style="margin-bottom: -20px;">Ko‘rsatkichlar</h4>
  <div class="chart-wrap">
    <canvas id="scoresChart"></canvas>
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
  const subjects = @json(collect($userData['subjects'] ?? [])->pluck('name')->toArray());
  const variants = @json(collect($final_test_result_data ?? [])->pluck('final_test.name')->unique()->toArray());
  const scoresByVariant = @json($scoresByVariant);

  const datasets = subjects.map((subject, idx) => {
    return {
      label: subject,
      data: variants.map(v => scoresByVariant[v][idx]),
      tension: 0.3,
      fill: false,
      pointRadius: 4,
      pointHoverRadius: 6,
      borderWidth: 2
    };
  });

  const ctx = document.getElementById("scoresChart").getContext("2d");
  new Chart(ctx, {
    type: "line",
    data: {
      labels: variants,
      datasets: datasets
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: {
          display: true,
          font: { size: 16 }
        },
        tooltip: {
          enabled: true,
          callbacks: {
            label: ctx => `${ctx.dataset.label}: ${ctx.formattedValue} ball`
          }
        },
        legend: {
          position: "top",
          labels: {
            font: {
              size: 16,
              weight: "600"
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          suggestedMax: 100,
          title: { display: false, text: "Ball" },
          ticks: { 
            stepSize: 10,
            font: { size: 16 }      
          }
        },
        x: {
          title: { display: false, text: "Variantlar" },
          ticks: {
            font: { size: 16 }   
          }
        }
      },
      interaction: {
        mode: "nearest",
        axis: "x",
        intersect: false
      }
    }
  });
</script>
@endsection