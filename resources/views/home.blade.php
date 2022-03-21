@extends('layout')
@section('title', 'Home')
@section('content')
  <main>
    <div class="mt-30.625em mb-0 flex flex-row items-end p-5.75em pt-0 pr-0 w-40em">
      <h1>Easily convert from one currency to another using the date</h1>
    </div>
    <!--<h1>Currency converter</h1>
    <h3>AUD</h3>
    <text>text</text>
    <h6>text</h6>
    <p>bruh</p>
    <div class="flex flex-col justify-center items-center">
      <div class="bg-blue-500 flex justify-center items-center w-full h-20">
        {{ ucwords($name[0] . " " . $name[1]) }}
      </div>
      <img src='@asset("favicon.svg")' alt="favicon">
      <div>
        {{--TODO: Handle forms and get the data from them--}}
        <form method="POST" action="" enctype="multipart/form-data">
          @csrf
          <input type="text" name="value" id="value">
          <input type="submit" name="" id="">
        </form>
      </div>
    </div>-->
  </main>
@endsection