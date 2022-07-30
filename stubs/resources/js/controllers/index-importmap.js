import { application } from 'libs/stimulus'

// Eager load all controllers defined in the import map under controllers/**/*_controller
import { eagerLoadControllersFrom } from 'libs/stimulus-loading'
eagerLoadControllersFrom('controllers', application)
