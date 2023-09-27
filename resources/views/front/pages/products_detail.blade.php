@extends('front.layouts.app')
@section('title')
    Ürün Detay
@endsection
@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="{{route('home')}}">Ana sayfa</a> <span class="mx-2 mb-0">/</span>
                    <strong class="text-black">{{$products->name ?? ''}}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset($products->image)}}" alt="{{$products->short_text}}" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2 class="text-black">{{$products->name ?? ''}}</h2>
                    <p>{!!$products->description!!}</p>
                    <p><strong class="text-primary h4">{{number_format($products->price),2}} TL</strong></p>
                    <form action="{{route('cart.add')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$products->id}}">
                        <div class="mb-1 d-flex">
                            <label for="option-xs" class="d-flex mr-3 mb-3">
                                <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-xs" name="color" {{$products->color == 'Siyah' ? 'checked' : ''}} value="Siyah"></span> <span class="d-inline-block text-black">Siyah</span>
                            </label>
                            <label for="option-s" class="d-flex mr-3 mb-3">
                                <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-s" name="color" {{$products->color == 'Silver' ? 'checked' : ''}}  value="Silver"></span> <span class="d-inline-block text-black">Silver</span>
                            </label>

                            <label for="option-m" class="d-flex mr-3 mb-3">
                                <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-m" name="color" {{$products->color == 'Gold' ? 'checked' : ''}}  value="Gold"></span> <span class="d-inline-block text-black">Gold</span>
                            </label>
                            <label for="option-l" class="d-flex mr-3 mb-3">
                                <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-l" name="color" {{$products->color == 'Mavi' ? 'checked' : ''}}  value="Mavi"></span> <span class="d-inline-block text-black">Mavi</span>
                            </label>
                            <label for="option-xxl" class="d-flex mr-3 mb-3">
                                <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-xxl" name="color" {{$products->color == 'Beyaz' ? 'checked' : ''}}  value="Beyaz"></span> <span class="d-inline-block text-black">Beyaz</span>
                            </label>
                            <label for="option-xxl" class="d-flex mr-3 mb-3">
                                <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-xxl" name="color" {{$products->color == 'Gri' ? 'checked' : ''}}  value="Gri"></span> <span class="d-inline-block text-black">Gri</span>
                            </label>
                        </div>
                        <div class="mb-5">
                            <div class="input-group mb-3" style="max-width: 120px;">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                                </div>
                                <input type="text" class="form-control text-center" value="1" name="qty" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                                </div>
                            </div>

                        </div>
                        <p><button type="submit" class="buy-now btn btn-sm btn-primary">Sepete Ekle</button></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(!empty($product) && $product ->count()>0)
    <div class="site-section block-3 site-blocks-2 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Diğer Ürünlerimiz</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nonloop-block-3 owl-carousel">

                            @foreach($product as $item)
                                <div class="item">
                                    <div class="block-4 text-center">
                                        <figure class="block-4-image">
                                            <img src="{{asset($item->image)}}" alt="Image placeholder" class="img-fluid">
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <h3><a href="">{{$item->name}}</a></h3>
                                            <p class="mb-0">{!! $item->description !!}</p>
                                            <p class="text-primary font-weight-bold">{{$item->price}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

@endsection
