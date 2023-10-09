@extends('admin.layouts.app')
@section('title')
    Kategori
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Kategoriler</h4>
                        <a  href="{{route('category.create')}}">
                        <p class="card-description">
                            Kategori Ekle
                        </p>
                        </a>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Resim</th>
                                    <th>Alt Kategori</th>
                                    <th>Slug</th>
                                    <th>Kategori Adı</th>
                                    <th>Durum</th>
                                    <th>Edit</th>
                                    <th>Eklenme Tarihi</th>
                                    <th>Güncellenme Tarihi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                <tr>

                                    <td>{{$category->id}}</td>
                                    <td class="py-1">
                                        <img src="{{asset($category->image)}}" alt="image">

                                    </td>

                                    <td>{{$category->cat_alt}}</td>
                                    <td>{{$category->slug}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->description}}</td>
                                    <td>
                                        @if($category->status)
                                            <a data-id="{{$category->id}}" href="{{route('category.status',  ['id' => $category->id])}}" class="btn btn-success durum">Aktif </a>
                                        @else
                                            <a data-id="{{$category->id}}" href="{{route('category.status',  ['id' => $category->id])}}" class="btn btn-danger durum">Pasif</a>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{route('category.edit',[$category->id])}}" class="btn btn-primary mr-2">Düzenle</a>

                                        <!--<button data-id="{{$category->id}}" class="btn btn-danger deleteRecord">Sil</button>-->
                                        <a data-id="{{$category->id}}" href=""  class="btn btn-danger silBtn">Sil </a>
                                    </td>
                                        <td>{{\Carbon\Carbon::parse($category->created_at)->format("d-m-Y H:i:s")}}</td>
                                        <td>{{\Carbon\Carbon::parse($category->updated_at)->format("d-m-Y H:i:s")}}</td>

                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>

   $(document).on('change','.durum',function (e){
        id=$(this).closest('.item').attr('item-id');
        statu=$(this).prop('checked');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:" POST",
            url: "{{route('category.status' ,  ['id' => $category->id])}}",
            data: {
                id:id,
                statu:statu
            },
            success:function (response){
                if (response.status == 'true'){
                    alertify.success("Durum aktif olarak değiştirildi!")
                }
                else {
                    alertify.error("Durum pasif olarak değiştirildi!")
                }
            }
        });
    });

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
