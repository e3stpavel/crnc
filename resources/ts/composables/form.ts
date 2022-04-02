import { render as ErrorsRender } from '../handling/error'
import { render as RateRender } from '../handling/rate'
import { render as ResultRender } from '../handling/result'
import { date, form, images, input, result, selects, swapTrigger, text, token } from './elements'
import api from './api'

// TODO: Add default amount value to showcase the result
// TODO: Check if value greater than 0 or if not show lazy load
// TODO: Find out why code stops working when errors occurred

const update = () => {
  // update selects images
  for (let i = 0; i < selects.length; i++) {
    const select = selects[i]
    const option = select.options[select.selectedIndex]

    // images for select fields
    const keys = option.id.split('~')
    const index: number = Number.parseInt(keys[0])

    images[index].src = `https://hatscripts.github.io/circle-flags/flags/${keys[1]}.svg`

    // text for input field
    if (select.id === 'from')
      text.innerText = option.value
  }
}

const request = async(endpoint: string, values: object): Promise<number | null> => {
  // try to make request to the server
  const uri = `http://localhost:8080${endpoint}`
  let response: number | null = null

  await api<{ value: number; errors: string[] }>(uri, 'POST', token.value, values)
    .then(({ value, errors }) => {
      // get the value and put it where we needed
      response = value

      // check for errors
      if (errors.length > 0) {
        ErrorsRender(errors)
        response = null
      }
    })
    .catch((error: Error) => {
      ErrorsRender([error.message])
      console.error(error)
      response = null
    })

  return response
}

export const formBehaviour = () => {
  // form handling
  form.addEventListener('input', async(e) => {
    e.preventDefault()

    update()
    if (form.checkValidity()) {
      // TODO: Add lazy load
      result.innerText = 'Loading...'

      await request('/', {
        from: selects[0].value,
        to: selects[1].value,
        amount: input.value,
        date: date.value,
      }).then((value) => {
        const pretty = selects[1].options[selects[1].selectedIndex].innerText
        if (value !== null) {
          ResultRender(
            input.value,
            value,
            selects[0].value,
            selects[1].value,
            pretty,
            date.value,
          )
        }
      })
    }
  })

  // rate field nesting
  const elements = [date, selects[0]]
  elements.forEach((element: HTMLElement) => {
    element.addEventListener('change', async() => {
      await request('/rate', { date: date.value, currency: selects[0].value })
        .then((value) => {
          if (value !== null)
            RateRender(value)
        })
    })
  })

  // swap button handling
  swapTrigger.addEventListener('click', (e) => {
    e.preventDefault()

    // swap selects
    const temp: string = selects[0].value
    selects[0].value = selects[1].value
    selects[1].value = temp
    update()
  })
}

// export const datepicker = () => {
//   // setting the datepicker
//   const today = new Date()
//   const month = (today.getMonth() + 1) < 10 ? `0${(today.getMonth() + 1)}` : today.getMonth() + 1
//   const day = today.getDate() < 10 ? `0${today.getDate()}` : today.getDate()
//   date.value = `${today.getFullYear()}-${month}-${day}`
// }

// export const rates = () => {
//   // update the rates on datepicker change
//   date.addEventListener('change', async() => {
//     // try request
//     const response = await fetch('http://localhost:8080/', {
//       method: 'POST',
//       headers: {
//         'content-type': 'application/json;charset=UTF-8',
//       },
//     })
//
//     const data = response.json()
//     if (!response.ok)
//       throw new Error(response.statusText)
//
//     data.then((res: Object) => {
//       console.log(res)
//     })
//   })
// }

// for (let i = 0; i < selects.length; i++) {
//   selects[i].addEventListener('change', (e: Event) => {
//     const select = <HTMLSelectElement>e.target!
//     const option = select.options[select.selectedIndex]
//
//     // images for select fields
//     const keys = option.id.split('~')
//     const index: number = Number.parseInt(keys[0])
//
//     images[index].src = `https://hatscripts.github.io/circle-flags/flags/${keys[1]}.svg`
//
//     // text for input field
//     if (select.id === 'from')
//       text.innerText = option.value
//   })
// }

/* export const updateInput = () => {
  const input = document.querySelector<HTMLInputElement>('#amount')
  const display = document.querySelector<HTMLInputElement>('#rate')

  input.addEventListener('change', () => {

  })
} */

// export const validate = () => {
//   if (form.checkValidity())
//     form.submit()
// }
