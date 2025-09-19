@extends('user.layout')

@section('main')
<div class="col-lg-9">
                            <!-- Start Enrole Course  -->
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
                                                <tr>
                                                    <td>1</td>
                                                    <td>Ona tili</td>
                                                    <td>3-variant</td>
                                                    <td>55</td>
                                                    <td>62</td>
                                                    <td>58</td>
                                                    <td>B2</td>
                                                    <td>19.09.2025</td>
                                                    <td>
  <a class="rbt-btn btn-xs bg-primary-opacity radius-round"
     href="#"
     title="Tavsiya"
     role="button"
     data-bs-toggle="modal"
     data-bs-target="#exampleModal">
    <i class="feather-eye pl--0"></i>
  </a>
</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Matematika</td>
                                                    <td>1-variant</td>
                                                    <td>43</td>
                                                    <td>57</td>
                                                    <td>50</td>
                                                    <td>B1</td>
                                                    <td>15.09.2025</td>
                                                     <td>
  <a class="rbt-btn btn-xs bg-primary-opacity radius-round"
     href="#"
     title="Tavsiya"
     role="button"
     data-bs-toggle="modal"
     data-bs-target="#exampleModal">
    <i class="feather-eye pl--0"></i>
  </a>
</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Ona tili</td>
                                                    <td>2-variant</td>
                                                    <td>62</td>
                                                    <td>63</td>
                                                    <td>63</td>
                                                    <td>A1</td>
                                                    <td>11.09.2025</td>
                                                     <td>
  <a class="rbt-btn btn-xs bg-primary-opacity radius-round"
     href="#"
     title="Tavsiya"
     role="button"
     data-bs-toggle="modal"
     data-bs-target="#exampleModal">
    <i class="feather-eye pl--0"></i>
  </a>
</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Ona tili</td>
                                                    <td>1-variant</td>
                                                    <td>55</td>
                                                    <td>53</td>
                                                    <td>54</td>
                                                    <td>B2</td>
                                                    <td>08.09.2025</td>
                                                     <td>
  <a class="rbt-btn btn-xs bg-primary-opacity radius-round"
     href="#"
     title="Tavsiya"
     role="button"
     data-bs-toggle="modal"
     data-bs-target="#exampleModal">
    <i class="feather-eye pl--0"></i>
  </a>
</td>
                                                </tr>

                                            </tbody>

                                        </table>
                                    </div>
                                    <div class="row">
                    <div class="col-lg-12 mt--40">
                        <nav>
                            <ul class="rbt-pagination">
                                <li><a href="#" aria-label="Previous"><i class="feather-chevron-left"></i></a></li>
                                <li><a href="#">1</a></li>
                                <li class="active"><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#" aria-label="Next"><i class="feather-chevron-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
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


    <div class="rbt-team-modal modal fade rbt-modal-default" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="rbt-round-btn" data-bs-dismiss="modal" aria-label="Close">
                                <i class="feather-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="inner">
                                <div class="row g-5 row--30 align-items-center">
                                    
                                    <div class="col-lg-12">
                                        <div class="rbt-team-details">
                                            <div class="author-info">
                                                <h4 class="title">Tavsiya</h4>
                                                <span class="team-form">
                                        <i class="feather-user"></i>
                                        <span class="location" style="font-size: 16px!important;"><strong>Abdullaev Abdulloh</strong>, siz <strong>Ona tili va adabiyot</strong> fanidan milliy sertifikat bo‘yicha ishlagan <br><strong>1-variant</strong>ingiz bo‘yicha quyidagi tavsiyalarni bildiramiz:</span>
                                                </span>
                                            </div>
                                            <p class="mb--10">Imlo qoidalarini yaxshi o‘zlashtiring;</p>
                                            <p class="mb--10">Kelishiklar va olmoshlar mavzusini mustahkamlashingiz lozim;</p>
                                            <p class="mb--10">Alisher Navoiy va Abdulla Qodiriyning asarlarini bir takrorlab oling.</p>

                                            
                                            <p class="mt--40" style="color: rgb(51, 51, 51); font-style: italic; font-size: 16; font-weight: 600;">Sizning kelgusi ishlaringizda muvaffaqiyat tilab qolamiz!</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="top-circle-shape"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
