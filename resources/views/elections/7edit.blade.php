@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Ellection Edit') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('elections.update',$election->id) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autocomplete="title" autofocus>
{{-- エラー表示 --}}
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category_name" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                                <div class="col-md-6">
                                    <input id="category_name" type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ old('category_name') }}" autocomplete="category_name" autofocus>
{{-- エラー表示 --}}
                                    @error('category_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="election0" class="col-md-4 col-form-label text-md-right">{{ __('name').'1' }}</label>
                                <div class="col-md-6">
                                    <input id="name0" type="text" class="form-control @error('name0') is-invalid @enderror" name="name0" value="{{ old('name0') }}" autocomplete="name0" autofocus>
                                </div>
                                <label for="election0" class="col-md-4 col-form-label text-md-right">{{ __('com').'1' }}</label>
                                    <textarea class="col-md-6" name="com0" id="com0" cols="10" rows="5"></textarea>
                                    
                                <label class="area-drop <?php if(!empty($err_msg['img'])) echo 'err'; ?>">
                                        <br>
                                        <h6 style="display:block; position:relative; top:0; left:0; font-size:16px;">
                                        clickでファイル選択
                                        </h6>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                                        <input type="file" accept="image/*" name="img" class="input-file" >
                                        <br>
                                </label>
                                    @error('name0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>

                            <div class="form-group row">
                                <label for="problem1" class="col-md-4 col-form-label text-md-right">{{ __('Problem').'2' }}</label>

                                <div class="col-md-6">
                                    <input id="problem1" type="text" class="form-control @error('problem1') is-invalid @enderror" name="problem1" value="{{ old('problem1') }}" autocomplete="problem1" autofocus>

                                    @error('problem1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

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
                            </div>



                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection