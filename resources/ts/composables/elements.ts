export const app = document.querySelector<HTMLDivElement>('#app')!

export const body = document.querySelector<HTMLBodyElement>('body')!

export const main = document.querySelector<HTMLElement>('main')!

export const form = document.querySelector<HTMLFormElement>('#calculator > form')!

export const images = document.querySelectorAll<HTMLImageElement>('.select-flag')!

export const selects = [
  document.querySelector<HTMLSelectElement>('#from')!,
  document.querySelector<HTMLSelectElement>('#to')!,
]

export const text = document.querySelector<HTMLParagraphElement>('#selected-currency')!

export const input = document.querySelector<HTMLInputElement>('#amount')!

export const date = document.querySelector<HTMLInputElement>('#date')!

export const fillable = document.querySelector<HTMLInputElement>('#rate')!

export const swapTrigger = document.querySelector<HTMLDivElement>('#swap')!

export const headerOverlay = document.querySelector<HTMLDivElement>('#header-overlay')!

export const overlayToggle = document.querySelector<HTMLImageElement>('#toggle-overlay')!

export const header = document.querySelector<HTMLDivElement>('#header')!

export const result = document.querySelector<HTMLHeadingElement>('#result')!

export const rate = document.querySelector<HTMLParagraphElement>('#result-rate')!

export const token = document.querySelector<HTMLInputElement>('[name="token"]')!

export const errorsWrapper = document.querySelector<HTMLParagraphElement>('#errors-wrapper')!

export const errors = document.querySelector<HTMLParagraphElement>('#errors-context')!
