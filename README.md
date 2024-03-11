# Jetstrap Minimal
## A package for Laravel Jetstream (4.x) with Livewire (3.x) + Blade to replace TailwindCSS with Bootstrap 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hlev/jetstrap-minimal.svg?style=flat-square)](https://packagist.org/packages/hlev/jetstrap-minimal)
[![Total Downloads](https://img.shields.io/packagist/dt/hlev/jetstrap-minimal.svg?style=flat-square)](https://packagist.org/packages/hlev/jetstrap-minimal)

Inspired by [joeycoonce/jetstrap/](https://github.com/joeycoonce/jetstrap/)

## Introduction
I could not find a working package for this setup, but I was overwhelmed by 
Tailwind, so decided to make one that aims at nothing more than making the latest 
Laravel Jetstream scaffolding work with the latest Bootstrap.

- no configuration
- 1 (internal) service provider
- no migrations, extraneous assets, etc.

## Installation
Should be installed in a new `laravel/jetstream livewire` project.

```
composer require hlev/jetstrap-minimal
```

**CAVEAT: the next step will overwrite/remove files!**
```
./artisan jetstrap:swap

npm update
```

The command:
- updates `package.json` removes Tailwind, adds Bootstrap, @popperjs/core and SASS
- removes `tailwind.config.js`
- updates `postcss.config.js` and `vite.config.js`
- removes `resources/css/`
- copies `sass` and `js` resources in place
- overwrites views and components with Bootstrap syntax in `resources/views`.
- changes the `/` route from `'welcome'` to `'dashboard'`

### Misc
#### Pagination
You may want to or already have run:
```
./artisan livewire:publish
```
Then update `config/livewire.php` to use `'bootstrap'` pagination. I did not test this.

#### Fixes
As for the components of the scaffolding, I mostly copied them over from [joeycoonce/jetstrap/](https://github.com/joeycoonce/jetstrap/), and fixed the following:
- `switchable.team.blade`: `'jet-'` prefix removed in `@props[ 'component' => ...]` reference
- `modal.blade.php`: `@entangle($attributes->wire('model'))` removed `.defer` to make modals work. As per [Livewire 3.x upgrade doc](https://livewire.laravel.com/docs/upgrading#entangle)
- fixed inclusion of `@livewireStyles` and `@vite()` assets
- added `@livewireScripts` to guest layout, since Jetstream 4.x uses Alpine on guest pages too
- adjusted the 2FA template to 4.x