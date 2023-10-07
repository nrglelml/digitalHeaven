@extends('front.layouts.app')
@section('title')
    Ürünler
@endsection
@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="{{route('home')}}">Ana Sayfa</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Ürünler</strong></div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">

            <div class="row mb-5">
                <div class="col-md-9 order-2">

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="float-md-left mb-4"><h2 class="text-black h5">Hemen Alışverişe Başla</h2></div>
                            <div class="d-flex">
                                <div class="dropdown mr-1 ml-md-auto">

                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuReference" data-toggle="dropdown">Sıralama</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                        <a class="dropdown-item" href="#" data-order="a_z_order">A - Z ye doğru sırala</a>
                                        <a class="dropdown-item" href="#" data-order="z_a_order">Z - A ya doğru sırala</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" data-order="price_min_order">Düşük fiyata göre sırala</a>
                                        <a class="dropdown-item" href="#" data-order="price_max_order">Yüksek fiyata göre sırala</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        @if (session()->get('success'))
                            <div class="alert alert-success">{{session()->get('success')}}</div>
                        @endif

                        @if (session()->get('error'))
                            <div class="alert alert-danger">{{session()->get('error')}}</div>
                        @endif
                    </div>
                    <div class="row mb-5">
                        @if(!empty($products) && $products->count() > 0)
                            @foreach($products as $product)
                                <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                                    <div class="block-4 text-center border">
                                        <figure class="block-4-image">
                                            <a href="{{route('products_detail',['slug' => $product->slug])}}"><img src="{{asset($product->image)}}" alt="{{$product->short_text}}" class="img-fluid"></a>
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <h3><a href="{{route('products_detail',['slug' => $product->slug])}}">{{$product->name}}</a></h3>
                                            <p class="mb-0">{!! $product->description !!}</p>
                                            <p class="text-primary font-weight-bold">{{number_format($product->price),2}}</p>
                                            <form action="{{route('cart.add')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <input type="hidden" name="color" value="{{$product->color}}">
                                                <button type="submit" class="buy-now btn btn-sm btn-primary">Sepete Ekle</button>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        @endif


                    </div>
                    <div class="row" data-aos="fade-up">
                        {{ $products->withQueryString()->links('vendor.pagination.bootstrap-4') }}
                       <div class="col-md-12 text-center">
                           {{-- <div class="site-block-27">
                               <ul>
                                   <li><a href="#">&lt;</a></li>
                                   <li class="active"><span>1</span></li>
                                   <li><a href="#">2</a></li>
                                   <li><a href="#">3</a></li>
                                   <li><a href="#">4</a></li>
                                   <li><a href="#">5</a></li>
                                   <li><a href="#">&gt;</a></li>
                               </ul>
                           </div>--}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 order-1 mb-5 mb-md-0">
                    <div class="border p-4 rounded mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Kategoriler</h3>
                        <ul class="list-unstyled mb-0">
                            @if(!empty($categories) && $categories->count() >0)
                                @foreach($categories->where('cat_alt',null) as $cat)
                                    <li class="mb-1"><a href="{{route($cat->slug.'ürün')}}" class="d-flex"><span>{{$cat->name}}</span> <span class="text-black ml-auto">({{$cat->getTotalProductCount()}})</span></a></li>
                                @endforeach
                            @endif

                        </ul>
                    </div>

                    <div class="border p-4 rounded mb-4">
                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Fiyata Göre Sırala</h3>
                            <div id="slider-range" class="border-primary"></div>
                            <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white" disabled="" />


                            <input type="text" name="text" id="priceBetween" class="form-control" hidden />

                        </div>



                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Renk</h3>
                            @if (!empty($colors))
                                @foreach ($colors as $key => $color)
                                    <label for="color{{$key}}" class="d-flex">
                                        <input type="checkbox" value="{{$color}}" id="color{{$key}}" {{isset(request()->color) && in_array($color,explode(',',request()->color)) ? 'checked' : '' }}  class="mr-2 mt-1 colorList"> <span class="text-black">{{$color}}</span>
                                    </label>
                                @endforeach
                            @endif


                        </div>
                        <div class="mb-4">
                            <button class="btn btn-block btn-primary filterBtn">Filtrele</button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="site-section site-blocks-2">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-md-1 site-section-heading pt-4">
                        <h2>Kategoriler</h2>
                    </div>
                </div>
                <div class="row">
                    @if (!empty($categories))
                        @foreach ($categories->where('cat_alt',null) as $category)
                            <div class="col-sm-12 col-md-12 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                                <a class="block-2-item" href="{{route($category->slug.'ürün')}}">
                                    <figure class="image">
                                        <img src="{{asset($category->image)}}" alt="" class="img-fluid">
                                    </figure>
                                    <div class="text">
                                        <h3>{{$category->name}}</h3>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </div>


@endsection
@section('customjs')
    <script>
        var maxprice="{{$maxprice}}";
        var defaultminprice="{{request()->min ?? 0}}";
        var defaultmaxprice="{{request()->max ?? $maxprice}}";
        var url = new URL(window.location.href);

        $(document).on('click', '.filterBtn', function(e) {
            filtrele();
        });


        function filtrele() {
            let colorList  = $(".colorList:checked" ).map((_,chk) => chk.value).get()
            let sizeList = $(".sizeList:checked").map((_,chk) => chk.value).get()
            if (colorList.length  > 0) {
                url.searchParams.set("color",  colorList.join(","))
            }else {
                url.searchParams.delete('color');
            }

            if (sizeList.length  > 0) {
                url.searchParams.set("size", sizeList.join(","))
            }else {
                url.searchParams.delete('size');
            }


            var price = $('#priceBetween').val().split('-');
            url.searchParams.set("min", price[0])

            url.searchParams.set("max", price[1])

            newUrl = url.href;
            window.history.pushState({}, '', newUrl);
            // location.reload();


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"GET",
                url:newUrl,
                success: function (response) {

                    $('.productContent').html(response.data);
                    $('.paginateButtons').html(response.paginate)
                }
            });


        }
    </script>
@endsection
