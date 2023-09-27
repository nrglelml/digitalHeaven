@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Basic Table</h4>
                    <p class="card-description">
                        <a href="" class="btn btn-primary">Yeni</a>
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
                                <th>Slogan</th>
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

                                            @php
                                                $images = collect($slider->images->data ?? '');
                                            @endphp
                                            <img src="{{asset($images->sortByDesc('vitrin')->first()['image'] ?? 'img/resimyok.png')}}" ></img>

                                        </td>
                                        <td>{{$slider->name}}</td>
                                        <td>{{$slider->content ?? ''}}</td>
                                        <td>{{$slider->link}}</td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="durum" data-on="Aktif" value="1" data-off="Pasif" data-onstyle="success" data-offstyle="danger" {{ $slider->status == '1' ? 'checked' : '' }}  data-toggle="toggle">
                                                </label>
                                            </div>



                                        </td>
                                        <td class="d-flex">
                                            <a href="" class="btn btn-primary mr-2">Düzenle</a>

                                            {{-- <form action="{{route('panel.slider.destroy',$slider->id)}}" method="POST">
                                                 @csrf
                                                 @method('DELETE')
                                                 <button type="submit" class="btn btn-danger">Sil</button>
                                             </form>  --}}


                                            <button type="button" class="silBtn btn btn-danger">Sil</button>
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
