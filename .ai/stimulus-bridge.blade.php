## Hotwired Native Bridge Components Guidelines

### BridgeComponent Class
- `BridgeComponent` extends Stimulus `Controller` with native bridge functionality
- Always set `static component` property that matches your native component name
- Place bridge components in `/bridge` subdirectory for easy identification

@verbatim
    ```javascript
    // resources/js/controllers/bridge/form_controller.js
    import { BridgeComponent, BridgeElement } from "@hotwired/hotwire-native-bridge"

    export default class extends BridgeComponent {
        static component = "form"  // Must match native component name
        static targets = [ "submit" ]

        submitTargetConnected(target) {
            const submitButton = new BridgeElement(target)
            const submitTitle = submitButton.title

            this.send("connect", { submitTitle }, () => {
                target.click()
            })
        }
    }
    ```
@endverbatim

### BridgeComponent Properties
- `this.platformOptingOut`: Whether controller is opted out for current platform
- `this.enabled`: Whether component is supported by the native app
- `this.bridgeElement`: Provides `this.element` wrapped in a BridgeElement
- `this.send(event, data, callback)`: Send message to native component

### BridgeElement Features
- `title`: Gets title from `data-bridge-title`, `aria-label`, or `textContent`/`value`
- `disabled`/`enabled`: Check/set disabled state
- `enableForComponent(component)`: Remove `data-bridge-disabled` attribute
- `bridgeAttribute(name)`: Get `data-bridge-{name}` attribute value
- `setBridgeAttribute(name, value)`: Set `data-bridge-{name}` attribute
- `removeBridgeAttribute(name)`: Remove `data-bridge-{name}` attribute

### HTML Structure

@verbatim
    ```html
    <form method="post" data-controller="bridge--form">
        <!-- form elements -->
        <button
            class="button"
            type="submit"
            data-bridge--form-target="submit"
            data-bridge-title="Submit">
            Submit Form
        </button>
    </form>
    ```
@endverbatim

### Data Attributes
- `data-bridge-title="My Title"`: Custom bridge title
- `data-bridge-disabled="true|false|ios|android"`: Control element availability
- `data-bridge-*`: Custom attributes accessible via BridgeElement
- `data-controller-optout-ios`: Opt-out component for iOS
- `data-controller-optout-android`: Opt-out component for Android

### Bridge Communication Pattern
1. Use target connection callbacks to initialize bridge elements
2. Send messages to native components with `this.send(event, data, callback)`
3. Always check `this.enabled` before bridge operations
4. Provide callback functions to handle native responses
