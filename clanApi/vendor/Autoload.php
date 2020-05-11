<?php

final class Autoload
{
	public function execute(): void
	{
		spl_autoload_register(function (string $class): void {
			$path = sprintf('%s.php', str_replace('\\', '/', $class));
			if (false === file_exists($path)) {
				return;
			}
			
			include_once $path;
		});
	}
}