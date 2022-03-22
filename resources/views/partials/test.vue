<template>
  <main class="px-5.75em">
    <div class="w-full h-screen py-5.75em flex flex-row items-end justify-between gap-x-1.5em">
      <!--<div class="bg-black w-full h-full" />-->
      <h1 class="max-w-5/9">
        Easily convert from one currency to another using the date
      </h1>

      <div class="flex flex-row items-center gap-x-1em">
        <img src="@asset(&quot;assets/icons/star.svg&quot;)" alt="" class="w-2em h-2em">
        <text>
          Simply type in the amount, choose the currency and the date to use it as a reference for the currency rate
        </text>
      </div>
    </div>

    <div class="w-full h-screen px-6.25em py-5.75em flex flex-col items-start">
      <h1>
        Currency converter
      </h1>

      <div id="calculator" class="relative bg-blue-100 w-full h-auto py-4em">
        <form class="flex flex-col w-full items-center" action="" method="post">
          <div class="flex flex-row items-center gap-x-1.5em">
            <div class="input-wrapper flex flex-row items-start gap-y-0.5em">
              <label for="amount">Amount</label>
              <div class="input w-full p-1em divide-x-0.5 divide-gray divide-opacity-60 bg-white">
                <text class="font-600 capitalize text-gray">
                  USD
                </text>
                <input
                  id="amount" type="number" name="amount"
                  inputmode="decimal" autocomplete="off" placeholder="1.00"
                >
              </div>
            </div>

            <label for="date">Date</label>
            <input id="date" type="date" name="date">

            <label for="rate">Exchange rate (1 EUR equals)</label>
            <input
              id="rate" class="pointer-events-none" type="number"
              name="rate" inputmode="decimal" autocomplete="off" placeholder="1.00"
            >
          </div>
          <div class="flex flex-row items-center">
            <label for="from">From currency</label>
            <select id="from" name="from">
              <option>EUR</option>
            </select>

            <button>e</button>

            <label for="to">To currency</label>
            <select id="to" name="to">
              <option>EUR</option>
            </select>
          </div>
        </form>
      </div>
    </div>
  </main>
</template>
