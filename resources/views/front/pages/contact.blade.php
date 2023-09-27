@extends('front.layouts.app')
@section('title')
   İletişim
@endsection
@section('content')
    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="h3 mb-3 text-black">Get In Touch</h2>
                </div>
                <div class="col-md-7">

                    <form action="{{route('contact.store')}}" method="post">
                        @csrf

                        <div class="p-3 p-lg-5 border">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="name" class="text-black">İsim <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="email" class="text-black">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="">
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="subject" class="text-black">Konu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="subject" name="subject">
                                    @error('subject')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="message" class="text-black">Mesaj <span class="text-danger">*</span></label>
                                    <textarea name="message" id=message" cols="30" rows="7" class="form-control"></textarea>
                                    @error('message')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Send Message">
                                </div>
                            </div>

                        </div>
                    </form>
                    <div>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{session('success')}}
                            </div>
                        @endif
                    </div>
                    <div>
                        @if(session('error'))
                            <div class="invaild-feedback" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                    </div>

            </div>
                </div>
                <div class="col-md-5 ml-auto"></div>
                            <div class="p-4 border mb-3">
                                <span class="d-block text-primary h6 text-uppercase">New York</span>
                                <p class="mb-0">203 Fake St. Mountain View, San Francisco, California, USA</p>
                            </div>
                            <div class="p-4 border mb-3">
                                <span class="d-block text-primary h6 text-uppercase">London</span>
                                <p class="mb-0">203 Fake St. Mountain View, San Francisco, California, USA</p>
                            </div>
                            <div class="p-4 border mb-3">
                                <span class="d-block text-primary h6 text-uppercase">Canada</span>
                                <p class="mb-0">203 Fake St. Mountain View, San Francisco, California, USA</p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
