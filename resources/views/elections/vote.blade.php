@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Practice').'「'.$election->title.'」' }}</div>

                    <div class="card-body text-center">
                        <p>{{ $election->name0 }}</p>
                        <p>{{ $election->name1 }}</p>
                        <p>{{ $election->name2 }}</p>
                        <div id="app">
                            <!-- デフォルトだとこの中ではvue.jsが有効 -->
                            <!-- example-component はLaravelに入っているサンプルのコンポーネント -->
                            <example-component title="{{ __('Practice').'「'.$election->title.'」' }}" :election="{{$election}}">

                            </example-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection