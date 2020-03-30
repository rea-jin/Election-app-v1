@extends('layouts.app')

@section('content')
<div class="container" style="">
    <h2 class="text-center">{{ __('みんなの選挙一覧') }}</h2>
    <p class="text-center">投票はそれぞれの選挙につき１回までです。どんどん投票しよう。</p>
    <div class="row" style="margin:0 auto;">

        @foreach ($elections as $election)

        <div class="col-md-6 mb-3" style="backgorund-color:#d393ff width:50%;">
            <div class="card" style="border:5px solid #009988">
                <div class="card-body mb-3">
                    <h3 class="card-title">{{ $election->title }}</h3>
                    <h5 class="card-title" style="overflow:hidden">{{ $election->subtitle }}</h3>
                    <a href="{{ route('elections.show',$election->id ) }}" class="btn btn-primary">{{ __('選挙を見る')  }}</a>
                    {{-- <a href="{{ route('elections.delete',$election->id ) }}" class="btn btn-primary">{{ __('選挙を削除する') }}</a> --}}
                </div>
            </div>
        </div>
        @endforeach
        {{-- {{ $paginator->links('elections.index') }} --}}
    </div>
    <div class="col-md-3 mt-3" style="width:20%; margin:0 auto;">
        {{ $elections->links() }}

    </div>
</div>
    
<hr>
@endsection