@extends('layout')
@section('title', 'Currency converter')
@section('content')

<main class="max-w-1560px mx-auto px-5.75em <md:px-1.5em">
  @include('sections.introduction')
  @include('sections.converter')
  @include('sections.rates')
</main>
@endsection