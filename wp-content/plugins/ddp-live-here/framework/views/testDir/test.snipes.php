@extends('layouts.testlayout')

@section('test-section')
  <h1 style="color:white;">{{ 'asshat' }}</h1>

  <div>{{ $testVar }}</div>

  <div>
  @if($testBool)
    {{ $testBool . ' is true'}}
  @else
   {{ "test bool false"}}
  @endif
  </div>


  {{-- test note --}}
  <div>
    <ul>
      @foreach($testArr as $t)
        <li>{{ $t }}</li>
      @endforeach
    </ul>
  </div>

  <div>
  {{__('$newthing exists?')}}

  {{ $newthing or 'nope'}}

  </div>

  @unless($unlessTest == 'seven')
    {{ 'Unless Test'}}
  @endunless
@stop