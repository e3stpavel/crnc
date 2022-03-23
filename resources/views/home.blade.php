@extends('layout')
@section('title', 'Home')
@section('content')

{{--TODO: Make all the data dynamic--}}
<main class="px-5.75em">
  <div class="w-full h-screen py-5.75em flex flex-row items-end justify-between gap-x-1.5em">
    <!--<div class="bg-black w-full h-full" />-->
    <h1 class="max-w-5/9">
      Easily convert from one currency to another using the date
    </h1>

    <div class="flex flex-row items-center gap-x-1em">
      <img src='@asset("assets/icons/star.svg")' alt="" class="w-2em h-2em">
      <text>
        Simply type in the amount, choose the currency and the date to use it as a reference for the currency rate
      </text>
    </div>
  </div>

  <div class="w-full h-screen px-6.25em py-5.75em flex flex-col items-start justify-evenly">
    <h1>
      Currency converter
    </h1>

    <div id="calculator" class="relative w-full h-auto py-4em">
      <form class="flex flex-col w-full items-center gap-y-1em pb-4em" action="" method="post">
        <div class="grid grid-flow-col grid-cols-autofit items-center gap-x-1.5em">
          <!-- Amount field -->
          <div class="input-wrapper">
            <label for="amount">Amount</label>
            <div class="input">
              <text class="font-600 uppercase text-gray pr-1em">
                USD
              </text>
              <input
                id="amount" type="number" name="amount"
                inputmode="decimal" autocomplete="off" placeholder="1.00"
              >
            </div>
          </div>

          <!-- Date picker -->
          <div class="input-wrapper">
            <label for="date">Date</label>
            <div class="input" class="divide-x-none">
              <input
                id="date" type="date" name="date" class="pl-0 uppercase"
              >
            </div>
          </div>

          <!-- Rate field -->
          <div class="input-wrapper">
            <label for="rate">Exchange rate (1 EUR equals)</label>
            <div class="input bg-cyan bg-opacity-45">
              <img src='@asset("assets/icons/cash.svg")' alt="" class="w-1.25em h-1.25em mr-1em">
              <input
                id="rate" class="pointer-events-none" type="number" 
                name="rate" inputmode="decimal" autocomplete="off" value="1.00"
              >
            </div>
          </div>
        </div>
        <div class="flex flex-row items-center gap-x-1.5em">
          <!-- From field -->
          <div class="input-wrapper">
            <label for="from">From currency</label>
            <div class="input">
              <div class="w-1.5em h-1.5em rounded-full mr-1em bg-gray">
                <!--<img class="w-full h-full" src='@asset("favicon.svg")' alt="">-->
              </div>
              <select id="from" name="from">
                <option>EUR – <span class="text-gray">Euro</span></option>
              </select>
            </div>
          </div>

          <!-- Swap button -->
          <div class="input-wrapper h-full">
            <text class="invisible">Helper</text>
            <button onclick="swapCurrencies()" class="swap p-1.25em">
              <img src='@asset("assets/icons/exchange.svg")' alt="" class="w-1em h-1em">
            </button>
          </div>

          <!-- To field -->
          <div class="input-wrapper">
            <label for="to">To currency</label>
            <div class="input">
              <div class="w-1.5em h-1.5em rounded-full mr-1em bg-gray">
                <!--<img class="w-full h-full" src='@asset("favicon.svg")' alt="">-->
              </div>
              <select id="to" name="to">
                <option>EUR – <span class="text-gray">Euro</span></option>
              </select>
            </div>
          </div>
        </div>
        {{--TODO: Onchange submit via Typescript--}}
        <input type="submit" value="" class="hidden">
      </form>
    </div>

    <div class="flex flex-col items-start justify-center ml-auto mr-auto">
      <text class="font-600 pb-0.25em">Result</text>
      <h1>100 Euro</h1>
      <p class="text-gray uppercase">1 EUR = 1 EUR, 22/03/2022</p>
    </div>
  </div>

  <div class="w-full py-5.75em flex flex-col items-start">
    <h1>
      Exchange rates
    </h1>

    <!--<table class="mt-4em text-left w-full">
      <thead class="border border-transparent border-t-gray border-b-gray border-opacity-60">
        <tr>
          <th><h6>Currency code</h6></th>
          <th><h6>Currency name</h6></th>
          <th><h6>Currency rate</h6></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="uppercase flex flex-row gap-x-1em">
            <div class="w-1.5em h-1.5em rounded-full bg-gray">

            </div>
            <h3>Aud</h3>
          </td>
          <td>
            <h3>Australian dollar</h3>
          </td>
          <td>
            <h3>1.45</h3>
          </td>
        </tr>
      </tbody>
    </table>-->

    <div class="mt-4em text-left w-full flex flex-col border-t border-t-gray border-opacity-60">
      <div class="row">
        <div class="td"><h6>Currency code</h6></div>
        <div class="td"><h6>Currency name</h6></div>
        <div class="td"><h6>Currency rate</h6></div>
      </div>      
      <div class="row">
        <div class="td flex flex-row gap-x-1em">
          <div class="w-1.5em h-1.5em rounded-full mt-0.09375em bg-gray"></div>
          <h3>Aud</h3>
        </div>
        <div class="td"><h3>Australian dollar</h3></div>
        <div class="td"><h3>1.45</h3></div>
      </div>
      
    </div>
  </div>
</main>

  <!--<main>
    <div class="mt-30.625em mb-0 flex flex-row items-end p-5.75em pt-0 pr-0 w-40em">
      <h1>Easily convert from one currency to another using the date</h1>
    </div>
    <h1>Currency converter</h1>
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
    </div>
  </main>-->
@endsection