@extends('admin.layouts.app')
@section('title')
    Slider Panel
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Basic Table</h4>
                    <p class="card-description">
                        <a href="{{route('slider.create')}}" class="btn btn-primary">Yeni</a>
                    </p>

                    @if (session()->get('success'))
                        <div class="alert alert-success">
                            {{session()->get('success')}}
                        </div>
                    @endif


                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Resim</th>
                                <th>Başlık</th>
                                <th>Açıklama</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (!empty($sliders) && $sliders->count() > 0)
                                @foreach ($sliders as $slider)
                                    <tr class="item" item-id="{{ $slider->id }}">
                                        <td class="py-1">
                                            <img src="{{asset($slider->image)}}" alt="image">

                                        </td>
                                        <td>{{$slider->name}}</td>
                                        <td>{{$slider->description ?? ''}}</td>
                                        <td>{{$slider->link}}</td>
                                        <td>
                                            @if($slider->status)
                                                <a data-id="{{$slider->id}}" href="{{route('slider.status',  ['id' => $slider->id])}}" class="btn btn-success durum">Aktif </a>
                                            @else
                                                <a data-id="{{$slider->id}}" href="{{route('slider.status',  ['id' => $slider->id])}}" class="btn btn-danger durum">Pasif</a>
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                                <a href="{{route('slider.edit',[$slider->id])}}" class="btn btn-primary mr-2">Düzenle</a>



                                            {{--  <form action="{{route('slider.destroy',$slider->id)}}" method="POST">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="btn btn-danger">Sil</button>
                                              </form>--}}


                                            <a data-id="{{$slider->id}}" href="{{route('slider.destroy' ,  [$slider->id])}}"  class="silBtn btn btn-danger">Sil </a>

                                        </td>
                                    </tr>

                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection
@section('js')
    <script>
        $(document).on('change','.durum',function (e){
            id=$(this).closest('.item').attr('item-id');
            statu=$(this).prop('checked');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:" POST",
                url: "{{route('slider.status',  ['id' => $slider->id])}}",
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
@endsection
