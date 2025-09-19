@extends('main.layout')

@section('index')
<div class="rbt-elements-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row gy-5 row--30">

                <div class="col-lg-6 offset-lg-3">
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                        <h3 class="title text-center">Parolni tiklash</h3>
                        <form class="max-width-auto">
                            <div class="form-group">
  <input name="code" type="text" required />
         <label>Tasdiqlash kodi *</label>
  <span class="focus-border"></span>
</div>
                            <div class="form-group">
                                <input name="password" type="password">
                                <label>Yangi parolni kiriting *</label>
                                <span class="focus-border"></span>
                            </div>
                            <div class="form-group">
                                <input name="password" type="password">
                                <label>Yangi parolni qaytadan kiriting *</label>
                                <span class="focus-border"></span>
                            </div>

                            <div class="form-submit-group">
                                <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Saqlash</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                        <p class="text-center mt--30"><a href="/login" style="color: rgb(6, 53, 209); font-weight: 500;">Tizimga kirish</a></p>
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