<?php

namespace Goldfinch\Illuminate\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'make:rule')]
class MakeRuleCommand extends GeneratorCommand
{
    protected static $defaultName = 'make:rule';

    protected $description = 'Create new rule';

    protected $path = 'app/src/Rules';

    protected $type = 'rule';

    protected $stub = './stubs/rule.stub';

    protected $prefix = 'Rule';

    protected function execute($input, $output): int
    {
        parent::execute($input, $output);

        return Command::SUCCESS;
    }
}
