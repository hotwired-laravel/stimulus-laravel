## Stimulus Core Philosophy
- Make Stimulus Controllers using the `artisan make:stimulus {name}` command
- Make Stimulus Bridge Controllers using the `artisan make:stimulus --bridge {name}` command
- Stimulus enhances static or server-rendered HTML with JavaScript controllers
- Store state in HTML data attributes, not JavaScript objects
- Design for progressive enhancement - work without JavaScript, enhance with it
- Build small, reusable controllers that connect to DOM elements

### Best Practices
- One responsibility per controller
- Design for multiple instances on same page
- Always cleanup in `disconnect()`
- Use semantic HTML first, enhance with Stimulus

#### Error Handling
```javascript
// Global
Stimulus.handleError = (error, message, detail) => {
  console.warn(message, detail)
  // Send to error tracking
}

// Controller method
async fetchData() {
  try {
    // async operation
  } catch (error) {
    this.showError(error.message)
  }
}
```

#### Default Events by Element
- `a`, `button`: `click`
- `form`: `submit`
- `input`, `textarea`: `input`
- `select`: `change`
- `details`: `toggle`

### Controller Structure

#### Basic Controller Template

@verbatim
    ```javascript
    // resources/js/controllers/example_controller.js
    import { Controller } from "@hotwired/stimulus"

    export default class extends Controller {
        static targets = [ "targetName" ]
        static values = { propertyName: Type }
        static classes = [ "className" ]

        connect() { /* When connected to DOM */ }
        disconnect() { /* When disconnected - cleanup here */ }

        actionMethod() { /* Handle events */ }
        propertyNameValueChanged() { /* When value changes */ }
    }
    ```
@endverbatim

### Naming Conventions
- **Files**: `hello_controller.js` → identifier `hello`
- **Nested**: `admin/users_controller.js` → identifier `admin--users`
- **Underscores**: become dashes in identifiers

### HTML Data Attributes

#### Controller Binding

@verbatim
    ```html
    <div data-controller="slideshow clipboard">
        <!-- Multiple controllers on one element -->
    </div>
    ```
@endverbatim

#### Actions (Event Handling)

@verbatim
    ```html
    <!-- Full syntax -->
    <button data-action="click->slideshow#next">Next</button>

    <!-- Default events (click for buttons) -->
    <button data-action="slideshow#next">Next</button>

    <!-- Multiple actions -->
    <input data-action="focus->form#highlight blur->form#reset">
    ```
@endverbatim

#### Targets

@verbatim
    ```html
    <!-- HTML -->
    <input data-slideshow-target="slide">

    <!-- Controller -->
    static targets = [ "slide" ]
    // Creates: this.slideTarget, this.slideTargets, this.hasSlideTarget
    ```
@endverbatim

#### Values (State Management)

@verbatim
    ```html
    <!-- HTML -->
    <div data-slideshow-index-value="1" data-slideshow-autoplay-value="true">

    <!-- Controller -->
    static values = {
        index: Number,
        autoplay: Boolean,
        delay: { type: Number, default: 5000 }
    }
    // Creates: this.indexValue, this.autoplayValue, etc.
    ```
@endverbatim

### Common Patterns

#### Lifecycle Management

@verbatim
    ```javascript
    connect() {
        this.startTimer()
    }

    disconnect() {
        this.stopTimer() // Always cleanup external resources
    }

    startTimer() {
        this.timer = setInterval(() => this.refresh(), 1000)
    }

    stopTimer() {
        if (this.timer) {
            clearInterval(this.timer)
        }
    }
    ```
@endverbatim

#### Progressive Enhancement

@verbatim
    ```javascript
    static classes = [ "supported" ]

    connect() {
        if ("clipboard" in navigator) {
            this.element.classList.add(this.supportedClass)
        }
    }
    ```
@endverbatim

#### Value Change Callbacks

@verbatim
    ```javascript
    static values = { index: Number }

    indexValueChanged() {
        // Called on initialization and value changes
        this.showCurrentSlide()
    }
    ```
@endverbatim

#### Action Parameters

@verbatim
    ```html
    <a data-loader-url-param="/messages" data-action="loader#load">Load</a>
    ```

    ```javascript
    load({ params: { url } }) {
    fetch(url).then(/* handle response */)
    }
    ```
@endverbatim

### Manual Registration

@verbatim
    ```javascript
    import { Application } from "@hotwired/stimulus"
    import HelloController from "./controllers/hello_controller"

    window.Stimulus = Application.start()
    Stimulus.register("hello", HelloController)
    ```
@endverbatim
