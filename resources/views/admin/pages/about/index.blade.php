@extends('admin.layouts.app')
@section('title')
    Hakkımızda
@endsection
@section('css')
    <style>
        .ck-content {
            height: 300px !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Hakkımızda</h4>

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

                    <form action="{{route('about.update')}}" class="forms-sample" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <div class="input-group col-xs-12">
                                <img src="{{asset($about->image ?? 'img/resimyok.webp')}}" alt="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image">Resim</label>
                            <input type="file" name="image" class="file-upload-default" style="display: none;">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Resim Yükle">
                                <span class="input-group-append">
            <button class="file-upload-browse btn btn-primary" type="button" onclick="document.querySelector('input[name=image]').click();">Yükle</button>
        </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="name">Başlık</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$about->name ?? ''}}" placeholder="about Başlık">
                        </div>
                        <div class="form-group">
                            <label for="editor">Hakkımızda</label>
                            <textarea class="form-control" id="editor" name="description" placeholder="Hakkımızda" rows="3">{!! $about->description ?? '' !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="text_1_icon">Icon 1</label>
                            <input type="text" class="form-control" id="text_1_icon" name="text_1_icon" value="{{$about->text_1_icon ?? ''}}" placeholder="Icon 1">
                        </div>
                        <div class="form-group">
                            <label for="text_1_title">Text Title 1</label>
                            <input type="text" class="form-control" id="text_1_title" name="text_1_title" value="{{$about->text_1_title ?? ''}}" placeholder="Text Title 1">
                        </div>
                        <div class="form-group">
                            <label for="text_1_content">Text 1</label>
                            <input type="text" class="form-control" id="text_1_content" name="text_1_content" value="{{$about->text_1_content ?? ''}}" placeholder="Text 1">
                        </div>

                        <div class="form-group">
                            <label for="text_2_icon">Icon 2</label>
                            <input type="text" class="form-control" id="text_2_icon" name="text_2_icon" value="{{$about->text_2_icon ?? ''}}" placeholder="Icon 2">
                        </div>
                        <div class="form-group">
                            <label for="text_2_title">Text Title 2</label>
                            <input type="text" class="form-control" id="text_2_title" name="text_2_title" value="{{$about->text_2_title ?? ''}}" placeholder="Text Title 2">
                        </div>
                        <div class="form-group">
                            <label for="text_2_content">Text 2</label>
                            <input type="text" class="form-control" id="text_2_content" name="text_2_content" value="{{$about->text_2_content ?? ''}}" placeholder="Text 2">
                        </div>

                        <div class="form-group">
                            <label for="text_3_icon">Icon 3</label>
                            <input type="text" class="form-control" id="text_3_icon" name="text_3_icon" value="{{$about->text_3_icon ?? ''}}" placeholder="Icon 3">
                        </div>
                        <div class="form-group">
                            <label for="text_3_title">Text Title 3</label>
                            <input type="text" class="form-control" id="text_3_title" name="text_3_title" value="{{$about->text_3_title ?? ''}}" placeholder="Text Title 3">
                        </div>
                        <div class="form-group">
                            <label for="text_3_content">Text 3</label>
                            <input type="text" class="form-control" id="text_3_content" name="text_3_content" value="{{$about->text_3_content ?? ''}}" placeholder="Text 3">
                        </div>




                        <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/translations/tr.js"></script>

    <script>

        const option = {
            language: 'tr',
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                ]
            },
        };

        ClassicEditor
            .create( document.querySelector( '#editor' ), option )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection
