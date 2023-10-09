@extends('admin.layouts.app')
@section('title')
    Ürün Ekle
@endsection
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">product</h4>

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


                    @if (!empty($product->id))
                        @php
                            $routelink = route('product.update',[$product->id]);

                        @endphp
                    @else
                        @php
                            $routelink = route('product.store');
                        @endphp
                    @endif

                        <form action="{{$routelink}}" class="forms-sample" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(!empty($product->id))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <div class="input-group col-xs-12">
                                    <img src="{{asset($product->image ?? 'img/resimyok.webp')}}" alt="">
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
                                <input type="text" class="form-control" id="name" name="name" value="{{$product->name ?? ''}}" placeholder="Başlık">
                            </div>
                            <div class="form-group">
                                <label for="name">Kategori</label>
                                <select name="category_id" id="" class="form-control">
                                    <option value="Kategori Seç"></option>
                                    @if($categories)
                                        @foreach($categories as $alt)
                                            <option value="{{$alt->id}}" {{isset($product) &&  $product->category_id == $alt->id ? 'selected' : ''}}>{{$alt->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">İçerik Yazısı</label>
                                <textarea class="form-control" id="editor" name="description" rows="3" placeholder="İçerik Yazısı">{{$product->description ?? ''}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="short_text">Kısa Açıklama</label>
                                <input type="text" class="form-control" id="short_text" name="short_text" value="{{$product->short_text ?? ''}}" placeholder="Kısa Açıklama">
                            </div>

                            <div class="form-group">
                                <label for="color">Renk</label>
                                <input type="text" class="form-control" id="color" name="color" value="{{$product->color ?? ''}}" placeholder="Renk">
                            </div>

                            <div class="form-group">
                                <label for="price">Fiyat</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{$product->price ?? ''}}" placeholder="Fiyat">
                            </div>

                            <div class="form-group">
                                <label for=" quantity">Adet Sayısı</label>
                                <input type="text" class="form-control" id=" quantity" name=" quantity" value="{{$product-> quantity ?? ''}}" placeholder="Adet Sayısı">
                            </div>

                            <div class="form-group">
                                <div class="form-check form-check-success">
                                    <label class="checkbox-button">
                                        <?php
                                        if ($product){
                                            $status=$product->status ? "checked" : '';
                                        }
                                        else{
                                            $status = 0;
                                        }

                                        ?>
                                        <input type="checkbox" id="status" name="status" value="{{ $status }}">
                                        <span class="checkmark"></span>
                                        Ana Sayfada Gösterilme Durumu
                                    </label>

                                </div>
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
