@extends('user.layout')

@section('main')
<div class="col-lg-9">
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
                                <div class="content">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">Asosiy</h4>
                                    </div>
                                    <div class="row g-5">

                                                <!-- Start Single Subject  -->
                                                <div class="col-lg-4 col-md-6 col-12">
                                                    <div class="rbt-card variation-01 rbt-hover">
                                                        
                                                        <div class="rbt-card-body">
                                                           
                                                            <h4 class="rbt-card-title"><a href="/user/free-test">Sinov testi</a>
                                                            </h4>
                                                            <div class="rbt-card-bottom">
                                                                <a class="rbt-btn btn-sm bg-primary-opacity w-100 text-center" href="/user/free-test">Test ishlash</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Single Subject  -->

                                                 <!-- Start Single Subject  -->
                                                <div class="col-lg-4 col-md-6 col-12">
                                                    <div class="rbt-card variation-01 rbt-hover">
                                                        
                                                        <div class="rbt-card-body">
                                                           
                                                            <h4 class="rbt-card-title"><a href="/user/select-test-type">Ona tili va adabiyot</a>
                                                            </h4>
                                                            <div class="rbt-card-bottom">
                                                                <a class="rbt-btn btn-sm bg-primary-opacity w-100 text-center" href="/user/select-test-type">Test ishlash</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Single Subject  -->
                                                <!-- Start Single Subject  -->
                                                <div class="col-lg-4 col-md-6 col-12">
                                                    <div class="rbt-card variation-01 rbt-hover">
                                                        
                                                        <div class="rbt-card-body">
                                                           
                                                            <h4 class="rbt-card-title"><a href="/user/select-test-type">Matematika</a>
                                                            </h4>
                                                            <div class="rbt-card-bottom">
                                                                <a class="rbt-btn btn-sm bg-primary-opacity w-100 text-center" href="/user/select-test-type">Test ishlash</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <!-- End Single Subject  -->
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
  // ---------- 1) MA'LUMOTLAR ----------
  const subjects = ["Ona tili", "Matematika"];
  const variants = ["1-variant", "2-variant", "3-variant", "4-variant"];

  const scoresByVariant = {
    "1-variant": [89, 76],
    "2-variant": [78, 88],
    "3-variant": [84, 80],
    "4-variant": [,35]
  };

  // ---------- 2) FANLARNI DATASETGA O‘ZGARTIRISH ----------
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

  // ---------- 3) GRAFIKNI CHIZISH ----------
  const ctx = document.getElementById("scoresChart").getContext("2d");
  new Chart(ctx, {
    type: "line",
    data: {
      labels: variants,   // X o‘qi = variantlar
      datasets: datasets  // Har bir fan = alohida chiziq
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
              weight: "600"   // 🔹 Fanlar (legend) font-weight: 600
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
            font: { size: 16 }   // 🔹 Y o‘qi yozuvlari 16px
          }
        },
        x: {
          title: { display: false, text: "Variantlar" },
          ticks: {
            font: { size: 16 }   // 🔹 X o‘qi yozuvlari 16px
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

<!-- <script>
    $.ajax({
        url: 'https://api.ntest.uz/api/profile/me',
        type: 'GET',
        headers: {
            'Authorization': 'Bearer ' + '{{ session('auth_token') }}'
        },
        success: function(response) {
            console.log(response);
            alert('Profile data: ' + JSON.stringify(response));
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Failed to load profile');
        }
    });
</script> -->
@endsection