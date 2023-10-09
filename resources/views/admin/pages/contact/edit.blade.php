@extends('admin.layouts.app')
@section('title')
    İletişim Ekle
@endsection
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">İletişim</h4>

                    @if ($errors)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{$error}}
                            </div>
                        @endforeach
                    @endif
                    @if (session()->get('success'))
                        <div class="alert alert-success">
                            {{session()->get('success')}}
                        </div>
                    @endif



                    <form action="{{route('contact.update',[$contact->id])}}" class="forms-sample" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">İsim</label>
                            <input type="text" class="form-control" id="name" readonly value="{{$contact->name ?? ''}}" placeholder="İsim">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" readonly value="{{$contact->email ?? ''}}" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="subject">Konu</label>
                            <input type="text" class="form-control" id="subject" readonly value="{{$contact->subject ?? ''}}" placeholder="Konu">
                        </div>
                        <div class="form-group">
                            <label for="message">Mesaj</label>
                            <textarea class="form-control" id="message" readonly placeholder="Mesaj" rows="3">{!! $contact->message ?? '' !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="ip">IP</label>
                            <input type="text" class="form-control" id="ip" readonly value="{{$contact->ip ?? ''}}" placeholder="IP">
                        </div>


                        <div class="form-group">
                            <label for="durum">Durum</label>
                            <?php
                            if ($contact){
                                $status=$contact->status ? "checked" : '';
                            }
                            else{
                                $status = 0;
                            }

                            ?>
                            <select name="status" id="status" class="form-control">
                                <option value="0" {{$status == '0' ? 'selected' : ''}}>Pasif</option>
                                <option value="1" {{$status == '1' ? 'selected' : ''}}>Aktif</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
