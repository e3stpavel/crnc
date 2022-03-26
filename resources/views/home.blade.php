@extends('layout')
@section('title', 'Home')
@section('content')

{{--TODO: Make all the data dynamic--}}
<main class="max-w-1560px mx-auto px-5.75em <md:px-1.5em">
  <EurFlag></EurFlag>
  @include('sections.introduction')
  @include('sections.converter')
  @include('sections.rates')
</main>
@endsection