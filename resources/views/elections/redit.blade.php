@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Ellection Edit') }}</div>

                    <div class="card-body">
                        {{-- <form method="POST" action="{{ route('elections.update',$election->id) }}"> --}}
                            @csrf

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    {{-- oldで取れない？ --}}
                                    {{-- validationで弾かれたとき、old使わないと入力内容が消えてしまう --}}
                                    {{-- <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $election->title }}" autocomplete="title" autofocus> --}}

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="subtitle" class="col-md-4 col-form-label text-md-right">説明</label>

                                <div class="col-md-6">
                                    {{-- <input id="subtitle" type="text" class="form-control @error('subtitle') is-invalid @enderror" namesubtitle value="{{ $election->subtitle }}" autocomplete="subtitle" autofocus> --}}

                                    @error('subtitle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

@foreach($b as $b)
<input value="{{ $c->name0 }}" type="text" class="form-control" autofocus>
<input value="{{ $bb }}" type="text" class="form-control" name="name"  autocomplete="name" autofocus>
{{-- @foreach($u_e2 as $u_e2) --}}
{{-- <input value="{{ $u_e2->id }}" type="text" class="form-control" name="name"  autocomplete="name" autofocus> --}}
<input value="{{ $ele->id }}" type="text" class="form-control" name="name"  autocomplete="name" autofocus>
{{-- @endforeach           --}}
@endforeach          
<br>

{{-- {{ var_dump($u_e1)}} --}}
{{-- {{ var_dump($u_e2)}} --}}
{{-- {{ var_dump($ele)}} --}}
{{-- {{ var_dump($a)}} --}}
<br>
<hr>
<br>
{{ var_dump($cc)}}
{{-- {{ var_dump($c)}} --}}
{{-- {{ var_dump($e_c1)}} --}}
{{-- {{ var_dump($c_e1)}} --}}
{{-- {{ var_dump($cess)}} --}}
    
@endsection 
