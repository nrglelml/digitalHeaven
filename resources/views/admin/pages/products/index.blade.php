@extends('admin.layouts.app')
@section('title')
    Ürünler
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ürünler</h4>
                        <a  href="{{route('product.create')}}">
                        <p class="card-description">
                            Ürün Ekle
                        </p>
                        </a>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Resim</th>
                                    <th>Başlık</th>
                                    <th>Kategori</th>
                                    <th>Açıklama</th>
                                    <th>Short_text</th>
                                    <th>Bilgiler</th>
                                    <th>Durum</th>
                                    <th>Edit</th>
                                    <th>Delete</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                <tr>

                                    <td>{{$product->id}}</td>
                                    <td class="py-1">
                                        @if ($product->image)
                                            <img src="{{ asset($product->image) }}" alt="image">
                                        @else
                                            <img src="{{ asset('storage/products/default-image.jpg') }}" alt="default image">
                                        @endif
                                    </td>

                                    <td>{{$product->name}}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td>{{$product->description}}</td>
                                    <td>{{$product->short_text}}</td>
                                    <td>{{$product->color}} <br>
                                        {{$product->price}} <br>
                                        {{$product->quantity}}
                                    </td>
                                    <td>
                                        @if($product->status)
                                            <a data-id="{{$product->id}}" href="{{route('product.status',  ['id' => $product->id])}}" class="btn btn-success changeStatus">Aktif </a>
                                        @else
                                            <a data-id="{{$product->id}}" href="{{route('product.status',  ['id' => $product->id])}}" class="btn btn-danger changeStatus">Pasif</a>
                                        @endif
                                    </td>

                                    <td>
                                        <a data-id="{{$product->id}}" class="btn btn-warning edit" href="{{route('product.edit' , [$product->id])}}" >Düzenle </a>
                                    </td>
                                    <td>
                                        <a data-id="{{$product->id}}" href="{{route('product.destroy' , $product->id)}}"  class="btn btn-danger silBtn">Sil </a>
                                    </td>


                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                {{$products->links('pagination::bootstrap-4')}}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
            <script>
                $(document).on('click', '.silBtn', function(e) {
                    e.preventDefault();
                    var item = $(this).closest('.item');
                    id = item.attr('data-id');
                    alertify.confirm("Silmek İstediğine Emin Misin?", "Silmek İstediğine Eminmisin?",
                        function() {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: "DELETE",
                                url: $(this).attr('href'),
                                data: {
                                    id: id,
                                },
                                success: function(response) {
                                    if (response.error == false) {
                                        item.remove();
                                        alertify.success(response.message);
                                    } else {
                                        alertify.error("Bir Hata Oluştu");
                                    }
                                }
                            });
                        },
                        function() {
                            alertify.error('Silme İptal Edildi');
                        });
                });

            </script>
@endsection
