# coffee_controller.coffee
import { Controller } from "@hotwired/stimulus"

export default class extends Controller
  @targets = [ "name", "output" ]

  greet: () ->
    this.outputTarget.textContent =
      "Hello, #{this.nameTarget.value}!"
