import { fillable } from '../composables/elements'

export const render = (value: number) => {
  fillable.value = value.toString()
}
