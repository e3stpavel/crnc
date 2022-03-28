IGBinary https://windows.php.net/downloads/pecl/releases/igbinary/3.2.7/
PHPRedis https://windows.php.net/downloads/pecl/releases/redis/5.3.7rc2/
RedisJson https://github.com/averias/phpredis-json, https://github.com/mkorkmaz/redislabs-rejson


Added session, using fetch
form.ts
`export const form = document.querySelector<HTMLFormElement>('#calculator > form')!

export const selects = [
document.querySelector<HTMLSelectElement>('#from')!,
document.querySelector<HTMLSelectElement>('#to')!,
]

export const input = document.querySelector<HTMLInputElement>("#amount")!
export const datepicker = document.querySelector<HTMLInputElement>("#date")!

const images = document.querySelectorAll<HTMLImageElement>('.select-flag')!
const text = document.querySelector<HTMLParagraphElement>('#selected-currency')!

export const updateSelects = () => {

for (let i = 0; i < selects.length; i++) {
selects[i].addEventListener('change', (e: Event) => {
const select = <HTMLSelectElement>e.target!
const option = select.options[select.selectedIndex]

      // images for select fields
      const keys = option.id.split('~')
      const index: number = Number.parseInt(keys[0])

      images[index].src = `https://hatscripts.github.io/circle-flags/flags/${keys[1]}.svg`

      // text for input field
      if (select.id === 'from')
        text.innerText = option.value
    })
}
}

/*export const updateInput = () => {
const input = document.querySelector<HTMLInputElement>('#amount')
const display = document.querySelector<HTMLInputElement>('#rate')

input.addEventListener('change', () => {

})
}*/

export const swapCurrencies = () => {
const swap = document.querySelector<HTMLDivElement>('#swap')!

swap.addEventListener('click', () => {
const temp: string = selects[0].value
selects[0].value = selects[1].value
selects[1].value = temp

    for (let i = 0; i < selects.length; i++) {
      const select = <HTMLSelectElement>selects[i]!
      const option = select.options[select.selectedIndex]

      // images for select fields
      const keys = option.id.split('~')
      const index: number = Number.parseInt(keys[0])

      images[index].src = `https://hatscripts.github.io/circle-flags/flags/${keys[1]}.svg`

      // text for input field
      if (select.id === 'from')
        text.innerText = option.value
    }
})
}

export const validate = () => {
input.addEventListener('focusout', () => {
if (datepicker.checkValidity()) {
if (form.checkValidity()) {
console.log("sending...")
form.submit()
}
}
})

datepicker.addEventListener('focusout', () => {
if (input.checkValidity()) {
if (form.checkValidity()) {
console.log("sending...")
form.submit()
}
}
})
}
`

