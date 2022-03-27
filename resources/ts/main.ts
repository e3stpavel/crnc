// import 'vite/modulepreload-polyfill'
import 'windi-base.css'
import 'windi-components.css'
import '~/css/style.css'
import 'windi-utilities.css'
// import 'virtual:windi-devtools'
import { headerOverlay, hideHeaderOverlay, highlightCurrentItem, overlayToggle, showHeaderOverlay } from './header'
import { validate, form, updateSelects } from "./form"

document.addEventListener('DOMContentLoaded', () => {
  document.addEventListener('scroll', () => {
    highlightCurrentItem()
  })

  overlayToggle.addEventListener('click', () => {
    if (headerOverlay.classList.contains('fixed') && overlayToggle.src.includes('close.svg'))
      hideHeaderOverlay()
    else
      showHeaderOverlay()
  })

  headerOverlay.addEventListener('click', () => {
    hideHeaderOverlay()
  })

  form.addEventListener('input', () => {
    updateSelects()
    validate()
  })
})

// const app = document.querySelector<HTMLDivElement>('#app')!
//
// app.innerHTML += `
//     <div class="bg-black text-white">hello</div>
// `
