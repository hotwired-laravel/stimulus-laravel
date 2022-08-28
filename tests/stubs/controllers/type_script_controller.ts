// type_script_controller.ts
import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
  static targets = ["name", "output"]

  declare readonly nameTarget: HTMLInputElement
  declare readonly outputTarget: HTMLElement

  greet() {
    this.outputTarget.textContent =
      `Hello, ${this.nameTarget.value}!`
  }
}
