<?php

declare (strict_types = 1);

namespace Larke\Admin\Traits;

use Closure;

use Larke\Admin\Facade\Extension;

trait ExtensionServiceProvider
{
    /**
     * All of the registered starting callbacks.
     *
     * @var array
     */
    protected array $startingCallbacks = [];

    /**
     * All of the registered started callbacks.
     *
     * @var array
     */
    protected array $startedCallbacks = [];
    
    /**
     * Register a starting callback to be run before the "start" method is called.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public function starting(Closure $callback): void
    {
        $this->startingCallbacks[] = $callback;
    }

    /**
     * Register a started callback to be run after the "start" method is called.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public function started(Closure $callback): void
    {
        $this->startedCallbacks[] = $callback;
    }

    /**
     * Call the registered starting callbacks.
     *
     * @return void
     */
    public function callStartingCallbacks(): void
    {
        foreach ($this->startingCallbacks as $callback) {
            $this->app->call($callback);
        }
    }

    /**
     * Call the registered started callbacks.
     *
     * @return void
     */
    public function callStartedCallbacks(): void
    {
        foreach ($this->startedCallbacks as $callback) {
            $this->app->call($callback);
        }
    }
    
    /**
     * 登陆过滤
     *
     * @param array $excepts 权限列表
     * @return void
     */
    public function authenticateExcepts(array $excepts): void
    {
        Extension::authenticateExcepts($excepts);
    }
    
    /**
     * 权限过滤
     *
     * @param array $excepts 权限列表
     * @return void
     */
    public function permissionExcepts(array $excepts): void
    {
        Extension::permissionExcepts($excepts);
    }
    
}
