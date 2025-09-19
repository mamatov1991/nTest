@extends('main.layout')

@section('index')
 <div class="rbt-cart-area bg-color-white rbt-section-gap">
        <div class="cart_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="#">
                            <!-- Cart Table -->
                            <div class="cart-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="pro-title">Ta’riflar</th>
                                            <th class="pro-price">Narxi</th>
                                            <th class="pro-quantity">Fanlar</th>
                                            <th class="pro-subtotal">Umumiy narxi</th>
                                            <th class="pro-remove">To‘lov</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="pro-title"><a href="#">Bir oylik</a></td>
                                            <td class="pro-price"><span>20 000 so‘m</span></td>
                                            <td class="pro-price"><span>Ona tili, Matematika</span></td>
                                            <td class="pro-subtotal"><span>40 000 so‘m</span></td>
                                            <td><a class="rbt-btn btn-gradient" href="#">Xarid qilish</a></td>
                                        </tr>
                                        <tr>
                                            <td class="pro-title"><a href="#">Uch oylik</a></td>
                                            <td class="pro-price"><span>50 000 so‘m</span></td>
                                            <td class="pro-price"><span>Ona tili, Matematika</span></td>
                                            <td class="pro-subtotal"><span>100 000 so‘m</span></td>
                                            <td><a class="rbt-btn btn-gradient" href="#">Xarid qilish</a></td>
                                        </tr>
                                        <tr>
                                            <td class="pro-title"><a href="#">Olti oylik</a></td>
                                            <td class="pro-price"><span>100 000 so‘m</span></td>
                                            <td class="pro-price"><span>Ona tili, Matematika</span></td>
                                            <td class="pro-subtotal"><span>200 000 so‘m</span></td>
                                            <td><a class="rbt-btn btn-gradient" href="#">Xarid qilish</a></td>
                                        </tr>
                                        <tr>
                                            <td class="pro-title"><a href="#">Bir yillik</a></td>
                                            <td class="pro-price"><span>180 000 so‘m</span></td>
                                            <td class="pro-price"><span>Ona tili, Matematika</span></td>
                                            <td class="pro-subtotal"><span>360 000 so‘m</span></td>
                                            <td><a class="rbt-btn btn-gradient" href="#">Xarid qilish</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                       </div>
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