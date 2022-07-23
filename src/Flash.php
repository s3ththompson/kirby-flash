<?php

namespace Jevets\Kirby;

use Kirby\Cms\App;

class Flash
{
    /**
     * An array of singleton instances
     *
     * @var Jevets\Kirby\Flash[]
     */
    protected static $instances = [];

    /**
     * A Session key identifier
     *
     * @var string
     */
    protected $sessionKey;

    /**
     * Container for the flashed data
     *
     * @var array
     */
    protected $initialData;

    /**
     * Get a new instance
     *
     * @param string $sessionKey
     * @return void
     */
    public function __construct($sessionKey = '_flash')
    {
        $this->sessionKey = $sessionKey;
        $this->initialData = App::instance()
            ->session()
            ->pull($this->sessionKey, []);
    }

    /**
     * Get the singleton instance
     *
     * @return Jevets\Kirby\Flash
     */
    public static function getInstance($sessionKey = '_flash')
    {
        if (!isset(static::$instances[$sessionKey])) {
            static::$instances[$sessionKey] = new static($sessionKey);
        }

        return static::$instances[$sessionKey];
    }

    /**
     * Get the session key
     *
     * @return string
     */
    public static function sessionKey()
    {
        return static::$instances['_flash']->getSessionKey();
    }

    /**
     * Set the session key
     *
     * @param string $sessionKey
     * @return void
     */
    public static function setSessionKey($sessionKey)
    {
        static::$instances['_flash'] = new static($sessionKey);
    }

    /**
     * Get the session key of this instance.
     *
     * @return string
     */
    public function getSessionKey()
    {
        return $this->sessionKey;
    }

    /**
     * Set flash data
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  mixed  optional set $value for current page load only
     * @return void
     */
    public function set($key, $value, $now = false)
    {
        $this->initialData[$key] = $value;
        if ($now === false) {
            $nextData = App::instance()
                ->session()
                ->get($this->sessionKey, []);
            $nextData[$key] = $value;
            App::instance()
                ->session()
                ->set($this->sessionKey, $nextData);
        }
    }

    /**
     * Get an item from the flash data by key
     *
     * @param  string  $key
     * @param  mixed  $default value to return if flash key doesn't exist
     * @return  mixed  $value or null
     */
    public function get($key, $default = null)
    {
        return isset($this->initialData[$key])
            ? $this->initialData[$key]
            : $default;
    }

    /**
     * Get all data from the flash
     *
     * @return  array
     */
    public function all()
    {
        return $this->initialData;
    }
}
