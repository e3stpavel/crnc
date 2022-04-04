import { render as ErrorsRender } from '../handling/error'
import { render as RateRender } from '../handling/rate'
import { render as ResultRender } from '../handling/result'
import { date, form, images, input, result, selects, swapTrigger, text, token } from './elements'
import api from './api'

// TODO: Add default amount value to showcase the result --- DONE!
// TODO: Check if value greater than 0 or if not show lazy load
// TODO: Find out why code stops working when errors occurred --- FIXED!
// TODO: Stylize the 404 page
// TODO: Add custom favicon --- DONE!
// TODO: Dockerized the app
// TODO: Get rid of unnecessary files

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

const preload = () => {
  const date = new Date()
  ResultRender('1', 1, 'EUR', 'EUR', 'EUR – Euro', date.toISOString())
}

const dispatchForm = () => {
  // dispatch the form element
  const event = new Event('input')
  form.dispatchEvent(event)
}

const datepicker = () => {
  date.addEventListener('change', (e) => {
    const element = <HTMLInputElement>e.target
    const now = new Date(element.value)
    const datetime = now.toLocaleDateString('en-US', { day: '2-digit', month: '2-digit', year: 'numeric' })
    const parts = datetime.split('/')

    element.setAttribute('data-date', `${parts[1]}/${parts[0]}/${parts[2]}`)
  })
}

const dispatchSelects = () => {
  // dispatch the form element
  const event = new Event('change')
  const elements = [selects[0], date]
  elements.forEach((element) => {
    element.dispatchEvent(event)
  })
}

export const formBehaviour = () => {
  // from data preload
  preload()

  // custom date format in datepicker
  datepicker()

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
    dispatchForm()
    dispatchSelects()
  })
}
