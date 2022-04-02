import { app } from '../composables/elements'

export const render = (errors: string[]) => {
  let list = `
    <text>${errors[0]}</text>
  `
  if (errors.length > 1) {
    list = `
      <text>Critical errors occurred:</text>
      <ul>
    `
    for (const errorsKey in errors) {
      const error = errors[errorsKey]

      list += `
        <li><p>${error}</p></li>
      `
    }
    list += `
      </ul>
    `
  }

  app.innerHTML += `
    <div 
      class="fixed top-1/5 left-1/2 transform -translate-x-1/2 bg-red-500 text-white p-2.265em"
    >
      ${list}
    </div>
  `
}
