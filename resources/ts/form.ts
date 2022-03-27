export const form = document.querySelector<HTMLFormElement>('#calculator > form')!

export const updateSelects = () => {
  const images = document.querySelectorAll<HTMLImageElement>('.select-flag')!
  const selects = [
    document.querySelector<HTMLSelectElement>('#from')!,
    document.querySelector<HTMLSelectElement>('#to')!,
  ]
  const text = document.querySelector<HTMLParagraphElement>('#selected-currency')!

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

export const validate = () => {
  if (form.checkValidity()) {
    form.submit()
  }
}
