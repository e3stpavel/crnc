<div id="rates" class="w-full py-5.75em flex flex-col items-start">
  <h1>
    Exchange rates
  </h1>

  <div class="mt-4em text-left w-full flex flex-col border-t border-t-gray border-opacity-60">
    <div class="row">
      <div class="td <sm:hidden">
        <h6>Currency code</h6>
      </div>
      <div class="td <sm:hidden">
        <h6>Currency name</h6>
      </div>
      <div class="td <sm:hidden">
        <h6>Currency rate</h6>
      </div>
      <div class="td hidden <sm:block">
        <h6>Code</h6>
      </div>
      <div class="td hidden <sm:block">
        <h6>Name</h6>
      </div>
      <div class="td hidden <sm:block">
        <h6>Rate</h6>
      </div>
    </div>
    @foreach($currencies as $currency)
      <div class="row">
        <div class="td flex flex-row gap-x-1em">
          <div class="w-1.5em h-1.5em rounded-full mt-0.09375em bg-gray <sm:hidden">
            <img
              src="https://hatscripts.github.io/circle-flags/flags/{{ $currency->getFlag() }}.svg"
              class="w-full h-full"
              alt=""
            >
          </div>
          <h3>{{ $currency->getCode() }}</h3>
        </div>
        <div class="td">
          <h3>{{ $currency->getName() }}</h3>
        </div>
        <div class="td">
          <h3>{{ $currency->getRate() }}</h3>
        </div>
      </div>
    @endforeach
  </div>
</div>