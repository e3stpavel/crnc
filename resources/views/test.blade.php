@extends('layout')
@section('title', 'Home')
@section('content')

  <div
    id="converter" class="w-full h-screen px-6.25em py-5.75em flex flex-col items-start justify-evenly
    <md:px-0 <md:h-auto"
  >
    <h1>
      Currency converter
    </h1>

    <div id="calculator" class="relative w-full h-auto py-4em">
      <form
        class="flex flex-col w-full items-center gap-y-1em pb-4em <md:gap-y-1.5em"
        action="/" method="post"
      >
        <input type="hidden" name="token" value="{{ $token }}" />
        <div
          class="grid grid-flow-col grid-cols-autofit items-center gap-x-1.5em
          <md:flex <md:flex-col <md:w-full <md:gap-y-1.5em"
        >
          <!-- Amount field -->
          <div class="input-wrapper">
            <label for="amount">Amount</label>
            <div class="input">
              <text id="selected-currency" class="font-600 uppercase text-gray pr-1em">
                EUR
              </text>
              <input
                id="amount" type="number" name="amount"
                inputmode="decimal" autocomplete="off" placeholder="1.00"
                required
              >
            </div>
          </div>

          <!-- Date picker -->
          <div class="input-wrapper">
            <label for="date">Date</label>
            <div class="input divide-x-none">
              <input
                id="date" type="date" name="date" class="pl-0 uppercase" required
                value="{{ $date }}"
              >
            </div>
          </div>

          <!-- Rate field -->
          <div class="input-wrapper">
            <label for="rate">Exchange rate (1 EUR equals)</label>
            <div class="input bg-cyan bg-opacity-45">
              <img src="@asset('assets/icons/cash.svg')" alt="" class="w-1.25em h-1.25em mr-1em">
              <input
                id="rate" class="pointer-events-none" type="number"
                name="rate" inputmode="decimal" autocomplete="off" value="1.00" disabled
              >
            </div>
          </div>
        </div>

        <div class="flex flex-row items-center gap-x-1.5em <md:flex-col <md:items-start <md:gap-y-1.5em <md:w-full">
          <!-- From field -->
          <div class="input-wrapper">
            <label for="from">From currency</label>
            <div class="input">
              <div class="w-1.5em h-1.5em rounded-full mr-1em bg-gray">
                <img
                  src="https://hatscripts.github.io/circle-flags/flags/european_union.svg" alt=""
                  class="w-full h-full select-flag"
                >
              </div>
              <select id="from" name="from" required>
                <option
                  value="{{ $euro->getCode() }}"
                  id="0~{{ $euro->getFlag() }}"
                >
                  {{ $euro->getCode() }} – {{ $euro->getName() }}
                </option>
                @foreach($currencies as $currency)
                  <option
                    value="{{ $currency->getCode() }}"
                    id="0~{{ $currency->getFlag() }}"
                  >
                    {{ $currency->getCode() }} – {{ $currency->getName() }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Swap button -->
          <div class="input-wrapper h-full">
            <text class="invisible">
              Helper
            </text>
            <div id="swap" class="swap p-1.25em cursor-pointer <md:p-1.75em <md:mx-auto">
              <img src="@asset('assets/icons/exchange.svg')" alt="" class="w-1em h-1em">
            </div>
          </div>

          <!-- To field -->
          <div class="input-wrapper">
            <label for="to">To currency</label>
            <div class="input">
              <div class="w-1.5em h-1.5em rounded-full mr-1em bg-gray">
                <img
                  src="https://hatscripts.github.io/circle-flags/flags/european_union.svg" alt=""
                  class="w-full h-full select-flag"
                >
              </div>
              <select id="to" name="to" required>
                <option
                  value="{{ $euro->getCode() }}"
                  id="1~{{ $euro->getFlag() }}"
                >
                  {{ $euro->getCode() }} – {{ $euro->getName() }}
                </option>
                @foreach($currencies as $currency)
                  <option
                    value="{{ $currency->getCode() }}"
                    id="1~{{ $currency->getFlag() }}"
                  >
                    {{ $currency->getCode() }} – {{ $currency->getName() }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="flex flex-col items-start justify-center ml-auto mr-auto">
      <text class="font-600 pb-0.25em">
        Result
      </text>
      <h1 id="result">100 Euro</h1>
      <p id="result-rate" class="text-gray uppercase">
        1 EUR = 1 EUR, 22/03/2022
      </p>
    </div>
  </div>

@endsection