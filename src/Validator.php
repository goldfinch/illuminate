<?php

namespace Goldfinch\Illuminate;

use SilverStripe\Core\Environment;
use Illuminate\Validation\Factory;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Validation\DatabasePresenceVerifier;

class Validator
{
    /**
     * Step data validator
     *
     * @var Factory
     */
    private $validator;

    /**
     * Get the validation factory instance.
     *
     * @return \Illuminate\Validation\Factory
     */
    public function getValidator()
    {
        return $this->validator;
    }

    public function __construct()
    {
        $loader = new FileLoader(new Filesystem(), BASE_PATH . '/vendor/illuminate/translation/lang');
        $translator = new Translator($loader, 'en');
        $this->validator = new Factory($translator, new Container());

        $db = new Manager;

        $db->addConnection([
            'driver' => 'mysql',
            'host'      => Environment::getEnv('SS_DATABASE_SERVER'),
            'database'  => Environment::getEnv('SS_DATABASE_NAME'),
            'username'  => Environment::getEnv('SS_DATABASE_USERNAME'),
            'password'  => Environment::getEnv('SS_DATABASE_PASSWORD'),
            'charset'   => 'utf8',
            // 'unix_socket' => '',
        ]);

        $this->validator->setPresenceVerifier(new DatabasePresenceVerifier($db->getDatabaseManager()));
    }
}
