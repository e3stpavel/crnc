import { rate, result } from '../composables/elements'

export const render = (fromValue: string, toValue: number, from: string, to: string, pretty: string, date: string) => {
  // make currency pretty string
  pretty = pretty.replace(to, '')
  pretty = pretty.replace('–', '')
  pretty = pretty.trim()

  // adding s to the end if plural
  if (toValue !== 1)
    pretty = `${pretty}s`

  result.innerText = `${toValue} ${pretty}`

  // 2022-03-22
  // to make it more clear for user used the Apr 1, 2022 date representation
  const d = new Date(date)
  date = d.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })

  rate.innerText = `${fromValue} ${from} = ${toValue} ${to}, ${date}`
}
