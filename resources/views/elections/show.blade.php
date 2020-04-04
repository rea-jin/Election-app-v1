@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card" style="width:80%;">
            <div class="card-header text-center h3">{{ $election->title }}</div>
            <h5 class="text-center lead mt-2" >{{ $election->subtitle }}</h5>
<hr style="font:bold; margin:10px 0;">
{{-- @if ($errors->first('voted'))　　　<!-- これはでない -->
<p class="validation">※{{$errors->first('password')}}</p>
@endif --}}
{{-- @error('vote')
<div class="alert alert-danger">{{ $message }}</div>
@enderror --}}

@if ($errors->any())
<div class="alert alert-danger">
 <ul>
   @foreach ($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
</div>
@endif

            <div class="card-body">
                <form id="vote" method="POST" action="{{ route('elections.vote',$election->id) }}" required class="@error('vote') is-invalid @enderror">
                    @csrf
                    <div class="text-center mb-2" style="font-weight:bold; font-size:1.5em;">総投票数：{{ $total_vote }} 票 </div>
                        
                    @foreach($candidates as $candidate)
                    @for($i=1; $i<=10; $i++)
                    <div class="col-md-12" style="margin:0 auto;">
                        <div class="col-md-12" style="">
                            <img src="{{ str_replace('public/', '/storage/',$election['img'.($i-1)]) }}" class="mb-2" width="100px" height="100px"  style="float:left; clear:both;">
                        </div>
                            <div class="col-md-8" style="float:left;">
                                {{-- <input id="name{{ $i-1 }}" type="text" class="form-control mt-2 @error('name'.($i-1)) is-invalid @enderror" name="{{ $i-1 }}" value="{{ $candidate['name'.($i-1)] }}" autocomplete="name{{ $i-1 }}" autofocus> --}}
                                <div id="name{{ $i-1 }}" type="text" class="strong mark lead mt-2 @error('name'.($i-1)) is-invalid @enderror" name="{{ $i-1 }}">{{ $candidate['name'.($i-1)] }}</div>
                                <input id="com{{ $i-1 }}" type="text" class="form-control mb-3 @error('com'.($i-1)) is-invalid @enderror" name="com{{ $i-1 }}" value="{{ $candidate['com'.($i-1)] }}" autocomplete="com{{ $i-1 }}" disabled="disabled">
                            </div>
                            {{-- votesのなかのuser_idから、election_idがあれば、非表示にして、結果を表示したい。 --}}
                            <div class="col-md-2" style="float:left;" >
                                
                                <p class="">候補{{ $i }}</p>
                                
                                @if($vote_user === false)
                                <input id="vote" type="radio" class="form-control" name="voted" value="name{{ $i-1 }}" autocomplete="name{{ $i-1 }}" autofocus>
                                
                                @elseif($vote_user === true)
                                <p class="text-center" style="background-color: aqua; font-size:16px;">{{ $count[$i-1] }} 票</p>
                                
                                @endif
                        </div>
                    </div>
                        
                        
                    @endfor
                    @endforeach
                    
                   
                </form>
                </div>
                {{-- form外からはform=idで指定 --}}
                @if($vote_user === false)
                {{-- @if(empty($voted)) --}}

            
                    <button id="voting" form="vote" type="submit" class="btn btn-success mb-4">
                        投票する！
                    </button>

                   

                @endif
                <a href="{{ route('elections')}}" class="btn btn-primary">前に戻る</a>
                {{-- {{ var_dump($vote_user) }} --}}

            <div>
            </div>
        </div>
        @endsection

