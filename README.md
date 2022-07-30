<p align="center" style="margin-top: 2rem; margin-bottom: 2rem;"><img src="/art/stimulus-laravel-logo.svg" alt="Logo Stimulus Laravel" /></p>

<p align="center">
    <a href="https://packagist.org/packages/tonysm/stimulus-laravel">
        <img src="https://img.shields.io/packagist/dt/tonysm/stimulus-laravel" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/tonysm/stimulus-laravel">
        <img src="https://img.shields.io/packagist/v/tonysm/stimulus-laravel" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/tonysm/stimulus-laravel">
        <img src="https://img.shields.io/packagist/l/tonysm/stimulus-laravel" alt="License">
    </a>
</p>

<a name="introduction"></a>
## Introduction

[Stimulus](https://stimulus.hotwired.dev/) is a JavaScript framework with modest ambitions. It doesn’t seek to take over your entire front-end in fact, it’s not concerned with rendering HTML at all. Instead, it’s designed to augment your HTML with just enough behavior to make it shine. Stimulus pairs beautifully with Turbo to provide a complete solution for fast, compelling applications with a minimal amount of effort. Together they form the core of [Hotwire](https://hotwired.dev/).

Stimulus for Laravel makes it easy to use this modest framework with both import-mapped and JavaScript-bundled apps. It relies on either [Importmap Laravel](https://github.com/tonysm/importmap-laravel) to make Stimulus available via ESM or a Node-capable [Laravel using Vite](https://laravel.com/docs/9.x/vite) to include Stimulus in the bundle. Make sure to install one of these first!

#### Inspiration

This package was inspired by the [stimulus-rails gem](https://github.com/hotwired/stimulus-rails).
