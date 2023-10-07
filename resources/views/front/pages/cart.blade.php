@extends('front.layouts.app')
@section('title')
    Sepet
@endsection
@section('content')


    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                < <div class="col-md-12 mb-0"><a href="{{route('home')}}">Ana Sayfa</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Sepet</strong></div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12">
                    @if (session()->get('success'))
                        <div class="alert alert-success">{{session()->get('success')}}</div>
                    @endif

                    @if (session()->get('error'))
                        <div class="alert alert-danger">{{session()->get('error')}}</div>
                    @endif
                </div>
                <div class="site-blocks-table">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="product-thumbnail">Görsel</th>
                            <th class="product-name">Ürün</th>
                            <th class="product-price">Fiyat</th>
                            <th class="product-quantity">Adet</th>
                            <th class="product-total">Toplam</th>
                            <th class="product-remove">Kaldır</th>
                        </tr>
                        </thead>
                        @if($cartItem)
                            @foreach($cartItem as $key=>$item)
                                <tbody>
                                <tr>
                                    <td class="product-thumbnail">
                                        <img src="{{asset($item['image'])}}" alt="görsel" class="img-fluid">
                                    </td>
                                    <td class="product-name">
                                        <h2 class="h5 text-black">{{$item['name' ?? '']}}</h2>
                                    </td>
                                    <td>{{$item['price']}} ₺</td>
                                    <td>
                                        <div class="input-group mb-3" style="max-width: 120px;">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                                            </div>
                                            <input type="text" class="form-control text-center" value="{{ $item['quantity']}}" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                                            </div>
                                        </div>

                                    </td>
                                    <td>{{$item['price'] * $item['quantity']}} ₺</td>
                                    <td>
                                        <form action="{{route('cart.remove')}}" method="POST" class="removeItem">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$key}}">
                                            <button href="#" class="btn btn-danger btn-sm">X</button>
                                        </form>
                                    </td>

                                </tr>
                                </tbody>
                            @endforeach
                        @endif
                    </table>
                </div>
                </form>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <button class="btn btn-primary btn-sm btn-block">Sepeti Güncelle</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-primary btn-sm btn-block">Sepeti Onayla</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('coupon.check')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-black h4" for="coupon">İndirim Kuponu</label>
                                        <p>İndirim Kupon kodu var ise girebilirsiniz.</p>
                                    </div>
                                    <div class="col-md-8 mb-3 mb-md-0">
                                        <input type="text" class="form-control py-3" id="coupon" value="{{session()->get('coupon_code' ?? '')}}" name="name" placeholder="İndirim Kupon Kodu">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary btn-sm">Kupon Kodu Onayla</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
                <div class="col-md-6 pl-5">
                    <div class="row justify-content-end">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12 text-right border-bottom mb-5">
                                    <h3 class="text-black h4 text-uppercase">Toplam Tutar</h3>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <span class="text-black">Toplam</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong class="text-black">{{session()->get('total_price' ?? '')}}</strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-lg py-3 btn-block" onclick="window.location='checkout.html'">Proceed To Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
