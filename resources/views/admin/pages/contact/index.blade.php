@extends('admin.layouts.app')
@section('title')
    İletişim Panel
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Basic Table</h4>


                    @if (session()->get('success'))
                        <div class="alert alert-success">
                            {{session()->get('success')}}
                        </div>
                    @endif


                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>İsim</th>
                                <th>Email</th>
                                <th>Konu</th>
                                <th>Mesaj</th>
                                <th>IP</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (!empty($contacts) && $contacts->count() > 0)
                                @foreach ($contacts as $contact)
                                    <tr class="item" item-id="{{ $contact->id }}">
                                        <td>{{$contact->name}}</td>
                                        <td>{{$contact->email}}</td>
                                        <td>{{$contact->subject}}</td>
                                        <td>{!! strLimit($contact->message,50,route('contact.edit',[$contact->id])) !!}</td>
                                        <td>{{$contact->ip}}</td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="durum" data-on="Aktif" value="1" data-off="Pasif" data-onstyle="success" data-offstyle="danger" {{ $contact->status == '1' ? 'checked' : '' }}  data-toggle="toggle">
                                                </label>
                                            </div>



                                        </td>
                                        <td class="d-flex">
                                            <a href="{{route('contact.edit',[$contact->id])}}" class="btn btn-primary mr-2">Düzenle</a>



                                            {{--  <form action="{{route('contact.destroy',$contact->id)}}" method="POST">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="btn btn-danger">Sil</button>
                                              </form>--}}


                                            <a data-id="{{$contact->id}}" href="{{route('contact.destroy' ,  [$contact->id])}}"  class="silBtn btn btn-danger">Sil </a>

                                        </td>
                                    </tr>

                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            {{$contacts->links('pagination::bootstrap-4')}}
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
                url: "{{route('contact.status')}}",
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
