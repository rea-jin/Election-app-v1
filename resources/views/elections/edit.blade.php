@extends('layouts.app')

@section('content')
    <div class="container contents">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Election Edit') }}</div>

                    {{-- <div id="app">
                    <example-component></example-component>
                    </div> --}}

                    <div class="card-body">
                        <form method="POST" action="{{ route('elections.update',$election->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('put') }}
                                        <div class="form-group row">
                                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
            
                                            <div class="col-md-6">
                                                {{-- oldで取れない？ --}}
                                                {{-- validationで弾かれたとき、old使わないと入力内容が消えてしまう --}}
                                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $election->title }}" autocomplete="title" autofocus>
            
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
                                                <input id="subtitle" type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" value="{{ $election->subtitle }}" autocomplete="subtitle" autofocus>
            
                                                @error('subtitle')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
            
            <hr>
            {{-- 候補名、コメント、画像登録 --------------------------------------------------------------}}
            @foreach($candidate as $candidate)
              @for($i = 1; $i<=2; $i++)
                                        <div class="form-group row">
                                        {{-- 候補名 --------------------------------}}
                                          <label for="name{{ $i-1 }}" class="col-md-4 col-form-label text-md-right mb-1"> {{ __('name').$i}}</label>
                                          <div class="col-md-6">
                                        {{-- オブジェクトから要素を取り出すには、配列として、キーが変わるようにループさせる --}}
                                              <input id="name{{ $i-1 }}" type="text" class="form-control @error('name'.($i-1)) is-invalid @enderror" name="name{{ $i-1 }}" value="{{ $candidate['name'.($i-1)] }}" autocomplete="name{{ $i-1 }}" autofocus> 
                                            </div>
                                        {{-- コメント --------------------------------}}
                                            <label for="com{{ $i-1 }}" class="col-md-4 col-form-label text-md-right mb-1">{{ __('com').$i }}</label>
                                            <div class="col-md-6">
                                                <input id="com{{ $i-1 }}" type="text" class="form-control @error('com'.($i-1)) is-invalid @enderror" name="com{{ $i-1 }}" value="{{ $candidate['com'.($i-1)] }}" autocomplete="com{{ $i-1 }}" autofocus>
                                            </div>
                                        {{-- 画像 --------------------------------}}
                                             <label for="img{{ $i-1 }}" class="area-drop mt-2 col-md-6 col-form-label text-md-right <?php if(!empty($err_msg['img'])) echo 'err'; ?>" style="margin:0 auto;">
                                                {{-- <img src="{{ $election['img'.($i-1)] }}" alt=""> --}}
                                                @if ($is_image)
                                                {{-- publicフォルダより画像のパスを取得して表示 --}}
                                                <figure>
                                                    <img class="img{{ $i-1 }}" src="{{ str_replace('public/', '/storage/', $election['img'.($i-1)]) }}" width="100px" height="100px" style="float:left; margin:5px;">
                                                </figure>
                                                @endif      

                                                <div class="" style="float:left;">
                                                        <h6 class="text-center">
                                                        clickでファイル選択 
                                                        </h6>
                                                        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                                                        <input type="file" accept="image/*" name="img{{ $i-1 }}" class="input" >
                                                    </div>
                                             </label>
                                            
                                                    @error('name'.($i-1))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                            </div> 
                @endfor
                @endforeach
                <hr>
                                        <div class="form-group row mb-0 text-center">
                                            <div class="text-center col-md-12">
                                                
                                                <button type="submit" class="btn btn-primary col-md-10 btn--color3 mb-3 mr-2">
                                                更新して保存
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    {{-- post送信のほうがいいか --}}
                                    {{-- <a href="{{ route('elections.mypage',$editflg=0 ) }}" class="btn btn-primary"> --}}
                                    <form id="start_ele" action="{{ route('elections.edit',$election->id) }}" method="post" class="text-center">
                                     <button type="submit" class="btn btn-info col-md-10 mb-2 mr-2" style="color:yellow;">
                                         @csrf
                                         選挙を開始する！
                                        </button>
                                    </form>
            {{-- </template> --}}
            
            {{-- <script>
                export default {
                    mounted() {
                        alert('Component mounted.')
                    }
                } --}}
                </div>
            </div>
        </div>
    </div>
@endsection 
