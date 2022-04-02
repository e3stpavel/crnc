// import 'vite/modulepreload-polyfill'
import 'windi-base.css'
import 'windi-components.css'
import '~/css/style.css'
import 'windi-utilities.css'
// import 'virtual:windi-devtools'
import { headerBehaviour } from './composables/header'
import { formBehaviour } from './composables/form'

document.addEventListener('DOMContentLoaded', () => {
  // header
  headerBehaviour()

  // form
  formBehaviour()
})

// const app = document.querySelector<HTMLDivElement>('#app')!
//
// app.innerHTML += `
//     <div class="bg-black text-white">hello</div>
// `
