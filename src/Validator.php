<?php

namespace Goldfinch\Illuminate;

use Illuminate\Validation\Factory;
use SilverStripe\Core\Environment;
use Illuminate\Container\Container;
use SilverStripe\Control\Controller;
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
    private static $validator;

    protected function __construct()
    {
        //
    }

    public static function make(
        array $data,
        array $rules,
        array $messages = [],
        array $attributes = [],
    ) {
        self::initValidator();
        self::initDBCapsule();

        return self::$validator->make($data, $rules, $messages, $attributes);
    }

    public static function validate(
        array $data,
        array $rules,
        array $messages = [],
        array $attributes = [],
    ) {
        $validator = self::make($data, $rules, $messages, $attributes);

        if ($validator->fails() && Controller::has_curr()) {
            return Controller::curr()->httpError(
                422,
                json_encode($validator->errors()->messages()),
            );
        }

        return $validator;
    }

    protected static function initValidator()
    {
        $loader = new FileLoader(
            new Filesystem(),
            BASE_PATH . '/vendor/illuminate/translation/lang',
        );
        $translator = new Translator($loader, 'en');
        self::$validator = new Factory($translator, new Container());
    }

    protected static function initDBCapsule()
    {
        $db = new Manager();

        $db->addConnection([
            'driver' => 'mysql',
            'host' => Environment::getEnv('SS_DATABASE_SERVER'),
            'database' => Environment::getEnv('SS_DATABASE_NAME'),
            'username' => Environment::getEnv('SS_DATABASE_USERNAME'),
            'password' => Environment::getEnv('SS_DATABASE_PASSWORD'),
            'charset' => 'utf8',
            // 'unix_socket' => '',
        ]);

        self::$validator->setPresenceVerifier(
            new DatabasePresenceVerifier($db->getDatabaseManager()),
        );
    }
}
