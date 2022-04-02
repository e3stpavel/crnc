import { Power2, gsap } from 'gsap'
import { body, header, headerOverlay, main, overlayToggle } from './elements'

const timeline = gsap.timeline({
  paused: true,
  defaults: {
    ease: Power2.easeInOut,
    duration: 0.5,
  },
})

timeline.from(headerOverlay, {
  opacity: 0,
  translateY: 25,
  transformOrigin: 'bottom',
})

const showHeaderOverlay = () => {
  // open the overlay
  headerOverlay.classList.replace('hidden', 'fixed')

  timeline.play()

  // make body non scrollable
  body.classList.add('overflow-hidden')

  // change the icon to x
  overlayToggle.src = 'assets/icons/close.svg'
}

const hideHeaderOverlay = () => {
  // play animation
  timeline.reverse()

  // close the overlay
  setTimeout(() => {
    headerOverlay.classList.replace('fixed', 'hidden')
  }, 500)

  // change the icon to menu
  overlayToggle.src = 'assets/icons/menu.svg'

  // make body scrollable
  body.classList.remove('overflow-hidden')
}

const highlightCurrentItem = () => {
  const sections: HTMLCollection = main.children

  for (let i = 0; i < sections.length; i++) {
    const section = sections.item(i)!
    const rect = section.getBoundingClientRect()

    if (rect.top && rect.left
      && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
      && rect.right <= (window.innerWidth || document.documentElement.clientWidth)) {
      const items = header.children.item(1)!
      const index = (i - 1) < 1 || (i - 1) === 2 ? i : i - 1
      const item = <HTMLElement>items.children.item(index)

      for (let j = 0; j < items.children.length; j++) {
        const el = <HTMLElement>items.children.item(j)

        el.style.opacity = '0.6'
        el.style.zIndex = 'unset'
      }

      if (item === null)
        return

      item.style.opacity = '1'
      item.style.zIndex = '1'
    }
  }
}

export const headerBehaviour = () => {
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
}
