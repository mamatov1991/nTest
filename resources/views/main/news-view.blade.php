@extends('main.sub-layout')

@section('index')
<div class="rbt-overlay-page-wrapper">
        <div class="breadcrumb-image-container breadcrumb-style-max-width">
            <div class="breadcrumb-content-top text-center">
            @foreach($news_single as $new_one)
                <h3 class="title">{{ $new_one['title'] ?? 'No title available' }}</h3>
                <ul class="meta-list justify-content-center mb--10">
                <li><i class="feather-calendar"></i>{{ date('d.m.Y', strtotime($new_one['created_at'])) }}</li>
                <li><i class="feather-eye"></i>{{ $new_one['views'] }}</li>
                </ul>
            </div>
        </div>

        <div class="rbt-blog-details-area rbt-section-gapBottom breadcrumb-style-max-width">
            <div class="blog-content-wrapper rbt-article-content-wrapper">
                <div class="content pb--30">
                {!! $new_one['content'] !!}

                </div>
                @endforeach
                <hr>
                <div class="related-post pt--30">
                    <div class="section-title text-start mb--40">
                        <h4 class="title">Yangiliklar</h4>
                    </div>

                    @foreach($news as $new)
                    <div class="col-12 col-lg-4">
                        <!-- Start News  -->
                        <div class="rbt-card event-grid-card variation-01 rbt-hover p-4">
                            <div class="rbt-card-img">
                                <a href="/news-view/{{ $new['id'] }}">
                                    <img src="{{ $new['image'] }}" alt="News image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <ul class="rbt-meta">
                                            <li><i class="feather-calendar"></i>{{ date('d.m.Y', strtotime($new['created_at'])) }}</li>
                                            <li><i class="feather-eye"></i>{{ $new['views'] }}</li>
                                        </ul>
                                <h4 class="rbt-card-title mb--5"><a href="/news-view/{{ $new['id'] }}">{{ $new['title'] }}</a></h4>
                                <div class="read-more-btn">
                                    <a class="rbt-btn btn-gradient hover-icon-reverse" href="/news-view/{{ $new['id'] }}" style="float:right;">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Batafsil</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End News  -->
                        @endforeach

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