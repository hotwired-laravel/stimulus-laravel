import { Application } from '@hotwired/stimulus'

const Stimulus = Application.start()

// Configure Stimulus development experience
application.debug = false
window.Stimulus   = Stimulus

export { Stimulus }
