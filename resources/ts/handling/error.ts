import { Power4, gsap } from 'gsap'
import { errors as errorsContext, errorsWrapper } from '../composables/elements'

export const render = (errors: string[]) => {
  gsap.set(errorsWrapper, {
    clipPath: 'polygon(0% 100%, 100% 100%, 100% 100%, 0% 100%)',
    display: 'none',
  })

  errorsContext.innerText = ''
  for (const errorsKey in errors)
    errorsContext.innerText += `${errors[errorsKey]}, `

  const tl = gsap.timeline({
    paused: true,
    defaults: {
      ease: Power4.easeOut,
      duration: 0.5,
    },
  })
  tl
    .set(errorsWrapper, {
      display: 'block',
    })
    .to(errorsWrapper, {
      clipPath: 'polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%)',
      transformOrigin: 'bottom center',
    })
    .to(errorsWrapper, {
      clipPath: 'polygon(0% 100%, 100% 100%, 100% 100%, 0% 100%)',
      transformOrigin: 'bottom center',
      delay: 5,
    })
    .set(errorsWrapper, {
      display: 'none',
    })

  tl.play()
}
