@extends('layouts.app')

@section('content')
<div class="container contents">
    <h2 class="text-center">{{ __('みんなの選挙一覧') }}</h2>
    <p class="text-center">投票はそれぞれの選挙につき１回までです。どんどん投票しよう。</p>
    <div class="row section__body">

        @foreach ($elections as $election)
        <div class="col-md-6 section__list">
            <div class="card section__card mb-3">
                <div class="card-body">
                    <h3 class="card-title section__card--title" >{{ $election->title }}</h3>
                    <h5 class="section__card--subtitle">{{ $election->subtitle }}</h3>
                    <a href="{{ route('elections.show',$election->id ) }}" class="btn section__card--btn btn-primary " >{{ __('選挙を見る')  }}</a>
                    {{-- <a href="{{ route('elections.delete',$election->id ) }}" class="btn btn-primary">{{ __('選挙を削除する') }}</a> --}}
                </div>
            </div>
        </div>
        @endforeach

        {{-- {{ $paginator->links('elections.index') }} --}}
    </div>
    <div class="paginator col-md-3 mt-3" >
        {{ $elections->links() }}

    </div>
</div>
    
<hr>
@endsection