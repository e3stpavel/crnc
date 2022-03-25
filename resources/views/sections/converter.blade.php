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
      action="" method="post"
    >
      <div
        class="grid grid-flow-col grid-cols-autofit items-center gap-x-1.5em
        <md:flex <md:flex-col <md:w-full <md:gap-y-1.5em"
      >
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
          <div class="input divide-x-none">
            <input
              id="date" type="date" name="date" class="pl-0 uppercase"
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
              name="rate" inputmode="decimal" autocomplete="off" value="1.00"
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
              <!--<img class="w-full h-full" src='@asset("favicon.svg")' alt="">-->
            </div>
            <select id="from" name="from">
              <option>EUR – <span class="text-gray">Euro</span></option>
            </select>
          </div>
        </div>

        <!-- Swap button -->
        <div class="input-wrapper h-full">
          <text class="invisible">
            Helper
          </text>
          <button onclick="swapCurrencies()" class="swap p-1.25em <md:p-1.75em <md:mx-auto">
            <img src="@asset('assets/icons/exchange.svg')" alt="" class="w-1em h-1em">
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

      <input type="submit" value="" class="hidden">
    </form>
  </div>

  <div class="flex flex-col items-start justify-center ml-auto mr-auto">
    <text class="font-600 pb-0.25em">
      Result
    </text>
    <h1>100 Euro</h1>
    <p class="text-gray uppercase">
      1 EUR = 1 EUR, 22/03/2022
    </p>
  </div>
</div>