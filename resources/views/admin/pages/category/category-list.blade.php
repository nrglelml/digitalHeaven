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
                        <a  href="{{route('category-add')}}">
                        <p class="card-description">
                            Kategori Ekle
                        </p>
                        </a>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                    <th>Alt Kategori</th>
                                    <th>Slug</th>
                                    <th>Kategori Adı</th>
                                    <th>Durum</th>
                                    <th>Eklenme Tarihi</th>
                                    <th>Güncellenme Tarihi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($category as $cat)
                                <tr>

                                    <td>{{$cat->id}}</td>
                                        <td>
                                            <a data-id="{{$cat->id}}" class="btn btn-warning edit" href="" >Düzenle<i class="fa fa-edit"></i> </a>
                                        </td>
                                        <td>
                                            <!--<button data-id="{{$cat->id}}" class="btn btn-danger deleteRecord">Sil</button>-->
                                            <a data-id="{{$cat->id}}" href=""  class="btn btn-danger deleteRecord">Sil<i class="fa fa-trash" aria-hidden="true"></i> </a>
                                        </td>
                                    <td>{{$cat->cat_alt}}</td>
                                    <td>
                                        {{$cat->slug}}
                                    </td>
                                        <td>{{$cat->name}}</td>
                                        <td>
                                            @if($cat->status)
                                                <a data-id="{{$cat->id}}" href="" class="btn btn-success changeStatus">Aktif </a>
                                            @else
                                                <a data-id="{{$cat->id}}" href="" class="btn btn-danger changeStatus">Pasif</a>
                                            @endif
                                        </td>
                                        <td>{{\Carbon\Carbon::parse($cat->created_at)->format("d-m-Y H:i:s")}}</td>
                                        <td>{{\Carbon\Carbon::parse($cat->updated_at)->format("d-m-Y H:i:s")}}</td>

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
