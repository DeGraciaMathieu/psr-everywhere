<?php

namespace App\Services;

class StandardizeService
{
    const SCRIPT = "phpcbf";
    const STANDARD = "--standard=PSR2,PSR1";

    /**
     * @param  string $path
     * @return void
     */
    public function process(string $path)
    {
        $commands = [
            self::SCRIPT,
            escapeshellarg($path),
            self::STANDARD,
        ];

        $this->execute($commands);
    }

    /**
     * @param  array $commands
     * @return void
     */
    protected function execute(array $commands)
    {
        shell_exec(implode(' ', $commands));
    }
}
