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
