<?php

namespace Hlev\JetstrapMinimal;


use Hlev\JetstrapMinimal\Commands\JetstrapMinimalCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class JetstrapMinimalServiceProvider extends PackageServiceProvider {

	public function configurePackage(Package $package): void {
		$package->name('jetstrap-minimal')
			->hasCommand(JetstrapMinimalCommand::class);
	}
}