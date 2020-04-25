@extends('layouts.app2')

@section('content')
<!-- particles.js container -->
<div class="containe top" >
<div id="particles-js">    

<div class="contents_img">
<div class="title">みんなの投票所</div>
<div class="sub">誰もが選挙を作り、誰もが投票できる
  <br>
  <span>それが、みんなの投票所</span>
</div>
<div class="link">
  <a href="{{ url('/elections') }}" style="text-decoration: none;">
    選挙一覧を見てみる<br>
      <span>v</span><br>
      <span>v</span><br>
      <img class="bg-img" src="{{ asset('/images/vote.png') }}" alt="">
  </a>
</div>
</div>
</div>
</div>
<hr>
@endsection