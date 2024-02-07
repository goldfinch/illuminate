<?php

namespace Goldfinch\Illuminate\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;

#[AsCommand(name: 'make:rule')]
class MakeRuleCommand extends GeneratorCommand
{
    protected static $defaultName = 'make:rule';

    protected $description = 'Create new rule';

    protected $path = 'app/src/Rules';

    protected $type = 'rule';

    protected $stub = './stubs/rule.stub';

    protected $suffix = 'Rule';
}
