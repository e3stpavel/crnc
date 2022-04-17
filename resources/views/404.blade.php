@extends('layout')
@section('title', '404')
@section('content')
  <main class="max-w-1560px mx-auto px-5.75em <md:px-1.5em">
    <div class="flex flex-col justify-center items-center h-screen">
      <h1 class="text-center text-12xl <sm:text-8xl">404</h1>
      <text class="text-center text-2xl w-1/3 <md:w-full">Sorry but it seems that page was not found!</text>
      <a class="button mt-2.265em <md:mt-4.75em <sm:w-full" href="/">
        <text>Back home</text>
        <img src="@asset('assets/icons/caret-45.svg')" alt="" class="w-1em h-1em ml-2.265em">
      </a>
    </div>
  </main>
@endsection
