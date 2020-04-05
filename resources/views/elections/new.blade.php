@extends('layouts.app')

@section('content')
    <div class="container contents">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Election Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('elections.new') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autocomplete="title" autofocus>

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
                                    <input id="subtitle" type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" value="{{ old('subtitle') }}" autocomplete="subtitle" autofocus>

                                    @error('subtitle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
<hr>


@for($i = 1; $i<=10; $i++)

                        <div class="form-group row">
                            <label for="name{{ $i-1 }} " class="col-md-4 col-form-label text-md-right mb-1"> {{ __('name').$i}}</label>
                                <div class="col-md-6">
                                <input id="name{{ $i-1 }}" type="text" class="form-control @error('name'.($i-1)) is-invalid @enderror" name="name{{ $i-1 }}" value=" {{old('name'.($i-1)) }}" autocomplete="name{{ $i-1 }}" autofocus>
                                </div>
                            <label for="com{{ $i-1 }}" class="col-md-4 col-form-label text-md-right mb-1">{{ __('com').$i }}</label>
                                <div class="col-md-6">
                                <input id="com{{ $i-1 }}" type="text" class="form-control @error('com'.($i-1)) is-invalid @enderror" name="com{{ $i-1 }}" value=" {{old('com'.($i-1)) }}" autocomplete="com{{ $i-1 }}" autofocus>
                                </div>
                             <label for="img{{ $i-1 }}" class="area-drop mt-2 ol-md-4 col-form-label text-center">
                                {{ '画像'.($i)  }}
                                        <br>
                                        <h6 class="text-center">
                                        clickでファイル選択
                                        </h6>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                                        <input type="file" accept="image/*" name="img{{ $i-1 }}" class="input-file" >
                                        <br>
                            </label>
                                    @error('name'.($i-1))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                    @endif
                            </div>
                      
                    
@endfor
                           
{{-- 
                            <div class="form-group row">
                                <label for="problem2" class="col-md-4 col-form-label text-md-right">{{ __('Problem').'3' }}</label>

                                <div class="col-md-6">
                                    <input id="problem2" type="text" class="form-control @error('problem2') is-invalid @enderror" name="problem2" value="{{ old('problem2') }}" autocomplete="problem0" autofocus>

                                    @error('problem2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}



                            <div class="form-group row mb-0 text-center">
                                <div class="text-center col-md-12">
                                    
                                    <button type="submit" class="btn btn-primary col-md-10 btn--color3 mb-3 mr-2">
                                    一時保存
                                    </button>
                                </div>
                            </div>
                        </form>
                        {{-- post送信のほうがいいか --}}
                        {{-- <a href="{{ route('elections.mypage',$editflg=0 ) }}" class="btn btn-primary"> --}}
                        {{-- <form id="start_ele" action="{{ route('elections.start',$election->id) }}" method="post" class="text-center">
                         <button type="submit" class="btn btn-info col-md-10 mb-2 mr-2" style="color:yellow;">
                             @csrf
                             選挙を開始する！
                            </button>
                        </form> --}}
                </div>
            </div>
        </div>
@endsection