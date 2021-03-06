@extends('layouts.app')

@section('content')
<div class="contents">
<div class="container contents-list">
    <h2>{{ __('作成中の選挙') }}</h2>
    <p>選挙開始は編集画面から行ってください</p>
{{-- {{var_dump($elections)}} --}}
    <div class="row" >
        @if(empty($elections))
        選挙を作成してください
        @elseif(!empty($elections))
        @foreach ($elections as $election)
        {{-- @if($editflg==1) --}}
        @if($election->delete_flg===0 && $election->start_flg===0)
        <div class="col-md-4 ml-2 card-list">
            <div class="card">
                <div class="card-body">
                    <h3 class="section__card--title">{{ $election->title }}</h3>
                    <a href="{{ route('elections.edit',$election->id ) }}" class="btn btn-primary float-right">{{ __('選挙を編集する') }}</a>
                 <form action="{{ route('elections.delete',$election->id ) }}" method="post" class="d-inline">
                      @csrf
                      {{ method_field('delete') }}
                       <button class="btn btn-danger float-left" onclick='return confirm("削除しますか？");'>{{ __('Go Delete')  }}</button>
                </form>
                </div>
            </div>
        </div>
        @endif
        @endforeach
        {{-- 選挙を作成してください。 --}}
        @endif
    </div>
</div>

<hr>
    <div class="container contents-list">
        <h2>{{ __('作成した開催済選挙') }}</h2>
        <p>編集はできません</p>
        <div class="row">
{{-- {{ ver_dump($elections) }} --}}
            @foreach ($elections as $election)
            @if($election->delete_flg===0 && $election->start_flg===1)
            <div class="col-md-4 card-list2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title section__card--title">{{ $election->title }}</h3>
                        {{-- <a href="{{ route('elections.show',$election->id ) }}" class="btn btn-primary">{{ __('選挙を見る')  }}</a> --}}
                        {{-- <a href="{{ route('elections.delete',$election->id ) }}" class="btn btn-primary">{{ __('選挙を削除する') }}</a> --}}
                        {{-- aタグだけだとget送信になり、deleteはサポートしていない。formでpost送信しないとダメか --}}
                        {{-- 外部キーがあるので、candidateから削除しないといけない delete_flgでやったほうがいい--}}
                        <a href="{{ route('elections.show',$election->id) }}" class="btn btn-primary float-right">{{ __('選挙を見る') }}</a>
                        <form action="{{ route('elections.delete',$election->id ) }}" method="post" class="d-inline">
                            @csrf
                            {{ method_field('delete') }}
                            <button class="btn btn-danger float-left" onclick='return confirm("削除しますか？");'>{{ __('削除する')  }}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <hr>
    <div class="container contents-list">
        <h2>{{ __('投票した選挙一覧') }}</h2>
        <div class="row">
            @if(empty($elections_v))
            投票した選挙はありません。

            @elseif(!empty($elections_v))
            @foreach ($elections_v as $election_v)
            @if($election_v->delete_flg===0)
            <div class="col-md-4 card-list3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title section__card--title">{{ $election_v->title }}</h3>
                        {{-- <h3 class="card-title">{{ $e_title->title }}</h3> --}}
                        <a href="{{ route('elections.show',$election_v->id ) }}" class="btn btn-primary float-right">{{ __('結果を見る') }}</a>
                        {{-- {{var_dump($vote_e_id) }} --}}
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            {{-- エラーが発生しました。 --}}
            @endif

        </div>
    </div>
</div>
@endsection