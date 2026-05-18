<?php

namespace DoctrineProxies\__PM__\App\Documents\Role;

class Generated014bede1ff217b1c900c7c55de32ad62 extends \App\Documents\Role implements \ProxyManager\Proxy\GhostObjectInterface
{
    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer3af7d = null;

    /**
     * @var bool tracks initialization status - true while the object is initializing
     */
    private $initializationTrackere150f = false;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesbb9cc = [
        
    ];

    /**
     * @var array[][] visibility and default value of defined properties, indexed by
     * property name and class name
     */
    private static $privateProperties1c209 = [
        'name' => [
            'App\\Documents\\Role' => true,
        ],
        'code' => [
            'App\\Documents\\Role' => true,
        ],
        'description' => [
            'App\\Documents\\Role' => true,
        ],
        'is_active' => [
            'App\\Documents\\Role' => true,
        ],
        'created_by' => [
            'App\\Documents\\Role' => true,
        ],
        'created_at' => [
            'App\\Documents\\Role' => true,
        ],
        'updated_by' => [
            'App\\Documents\\Role' => true,
        ],
        'updated_at' => [
            'App\\Documents\\Role' => true,
        ],
    ];

    /**
     * @var string[][] declaring class name of defined protected properties, indexed by
     * property name
     */
    private static $protectedProperties6f23c = [
        
    ];

    private static $signature014bede1ff217b1c900c7c55de32ad62 = 'YTo0OntzOjk6ImNsYXNzTmFtZSI7czoxODoiQXBwXERvY3VtZW50c1xSb2xlIjtzOjc6ImZhY3RvcnkiO3M6NDQ6IlByb3h5TWFuYWdlclxGYWN0b3J5XExhenlMb2FkaW5nR2hvc3RGYWN0b3J5IjtzOjE5OiJwcm94eU1hbmFnZXJWZXJzaW9uIjtzOjQ4OiJ2MS4wLjE5QGMyMDI5OWFhOWY0OGE2MjIwNTI5NjRhNzVjNWE0Y2VmMDE3Mzk4YjIiO3M6MTI6InByb3h5T3B0aW9ucyI7YToxOntzOjE3OiJza2lwcGVkUHJvcGVydGllcyI7YToxOntpOjA7czoyMjoiAEFwcFxEb2N1bWVudHNcUm9sZQBpZCI7fX19';

    /**
     * Triggers initialization logic for this ghost object
     *
     * @param string  $methodName
     * @param mixed[] $parameters
     *
     * @return mixed
     */
    private function callInitializer54965($methodName, array $parameters)
    {
        if ($this->initializationTrackere150f || ! $this->initializer3af7d) {
            return;
        }

        $this->initializationTrackere150f = true;

        static $cacheApp_Documents_Role;

        $cacheApp_Documents_Role ?? $cacheApp_Documents_Role = \Closure::bind(static function ($instance) {
            $instance->description = null;
            $instance->is_active = true;
            $instance->created_by = null;
            $instance->created_at = null;
            $instance->updated_by = null;
            $instance->updated_at = null;
        }, null, 'App\\Documents\\Role');

        $cacheApp_Documents_Role($this);




        $nonReferenceableProperties = new class() {
            public ?string $name_on_App_Documents_Role;
            public ?string $code_on_App_Documents_Role;
        };
        $properties = [
            '' . "\0" . 'App\\Documents\\Role' . "\0" . 'name' => & $nonReferenceableProperties->name_on_App_Documents_Role,
            '' . "\0" . 'App\\Documents\\Role' . "\0" . 'code' => & $nonReferenceableProperties->code_on_App_Documents_Role,
        ];

        static $cacheFetchApp_Documents_Role;

        $cacheFetchApp_Documents_Role ?? $cacheFetchApp_Documents_Role = \Closure::bind(function ($instance, array & $properties) {
            $properties['' . "\0" . 'App\\Documents\\Role' . "\0" . 'description'] = & $instance->description;
            $properties['' . "\0" . 'App\\Documents\\Role' . "\0" . 'is_active'] = & $instance->is_active;
            $properties['' . "\0" . 'App\\Documents\\Role' . "\0" . 'created_by'] = & $instance->created_by;
            $properties['' . "\0" . 'App\\Documents\\Role' . "\0" . 'created_at'] = & $instance->created_at;
            $properties['' . "\0" . 'App\\Documents\\Role' . "\0" . 'updated_by'] = & $instance->updated_by;
            $properties['' . "\0" . 'App\\Documents\\Role' . "\0" . 'updated_at'] = & $instance->updated_at;
        }, null, 'App\\Documents\\Role');

        $cacheFetchApp_Documents_Role($this, $properties);

        $result = $this->initializer3af7d->__invoke($this, $methodName, $parameters, $this->initializer3af7d, $properties);
        static $cacheAssignApp_Documents_Role;

        $cacheAssignApp_Documents_Role ?? $cacheAssignApp_Documents_Role = \Closure::bind(function ($instance, $nonReferenceableProperties) {
            isset($nonReferenceableProperties->name_on_App_Documents_Role) && $instance->name = $nonReferenceableProperties->name_on_App_Documents_Role;
            isset($nonReferenceableProperties->code_on_App_Documents_Role) && $instance->code = $nonReferenceableProperties->code_on_App_Documents_Role;
        }, null, 'App\\Documents\\Role');

        $cacheAssignApp_Documents_Role($this, $nonReferenceableProperties);
        $this->initializationTrackere150f = false;

        return $result;
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\App\Documents\Role $instance) {
            unset($instance->name, $instance->code, $instance->description, $instance->is_active, $instance->created_by, $instance->created_at, $instance->updated_by, $instance->updated_at);
        }, $instance, 'App\\Documents\\Role')->__invoke($instance);

        $instance->initializer3af7d = $initializer;

        return $instance;
    }

    public function & __get($name)
    {
        $this->initializer3af7d && ! $this->initializationTrackere150f && $this->callInitializer54965('__get', array('name' => $name));

        if (isset(self::$publicPropertiesbb9cc[$name])) {
            return $this->$name;
        }

        if (isset(self::$protectedProperties6f23c[$name])) {
            if ($this->initializationTrackere150f) {
                return $this->$name;
            }

            // check protected property access via compatible class
            $callers      = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller       = isset($callers[1]) ? $callers[1] : [];
            $object       = isset($caller['object']) ? $caller['object'] : '';
            $expectedType = self::$protectedProperties6f23c[$name];

            if ($object instanceof $expectedType) {
                return $this->$name;
            }

            $class = isset($caller['class']) ? $caller['class'] : '';

            if ($class === $expectedType || is_subclass_of($class, $expectedType) || $class === 'ReflectionProperty') {
                return $this->$name;
            }
        } elseif (isset(self::$privateProperties1c209[$name])) {
            // check private property access via same class
            $callers = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller  = isset($callers[1]) ? $callers[1] : [];
            $class   = isset($caller['class']) ? $caller['class'] : '';

            static $accessorCache = [];

            if (isset(self::$privateProperties1c209[$name][$class])) {
                $cacheKey = $class . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function & ($instance) use ($name) {
                        return $instance->$name;
                    }, null, $class);

                return $accessor($this);
            }

            if ($this->initializationTrackere150f || 'ReflectionProperty' === $class) {
                $tmpClass = key(self::$privateProperties1c209[$name]);
                $cacheKey = $tmpClass . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function & ($instance) use ($name) {
                        return $instance->$name;
                    }, null, $tmpClass);

                return $accessor($this);
            }
        }

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $realInstanceReflection->newInstanceWithoutConstructor();
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer3af7d && $this->callInitializer54965('__set', array('name' => $name, 'value' => $value));

        if (isset(self::$publicPropertiesbb9cc[$name])) {
            return ($this->$name = $value);
        }

        if (isset(self::$protectedProperties6f23c[$name])) {
            // check protected property access via compatible class
            $callers      = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller       = isset($callers[1]) ? $callers[1] : [];
            $object       = isset($caller['object']) ? $caller['object'] : '';
            $expectedType = self::$protectedProperties6f23c[$name];

            if ($object instanceof $expectedType) {
                return ($this->$name = $value);
            }

            $class = isset($caller['class']) ? $caller['class'] : '';

            if ($class === $expectedType || is_subclass_of($class, $expectedType) || $class === 'ReflectionProperty') {
                return ($this->$name = $value);
            }
        } elseif (isset(self::$privateProperties1c209[$name])) {
            // check private property access via same class
            $callers = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller  = isset($callers[1]) ? $callers[1] : [];
            $class   = isset($caller['class']) ? $caller['class'] : '';

            static $accessorCache = [];

            if (isset(self::$privateProperties1c209[$name][$class])) {
                $cacheKey = $class . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function ($instance, $value) use ($name) {
                        return ($instance->$name = $value);
                    }, null, $class);

                return $accessor($this, $value);
            }

            if ('ReflectionProperty' === $class) {
                $tmpClass = key(self::$privateProperties1c209[$name]);
                $cacheKey = $tmpClass . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function ($instance, $value) use ($name) {
                        return ($instance->$name = $value);
                    }, null, $tmpClass);

                return $accessor($this, $value);
            }
        }

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $realInstanceReflection->newInstanceWithoutConstructor();
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer3af7d && $this->callInitializer54965('__isset', array('name' => $name));

        if (isset(self::$publicPropertiesbb9cc[$name])) {
            return isset($this->$name);
        }

        if (isset(self::$protectedProperties6f23c[$name])) {
            // check protected property access via compatible class
            $callers      = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller       = isset($callers[1]) ? $callers[1] : [];
            $object       = isset($caller['object']) ? $caller['object'] : '';
            $expectedType = self::$protectedProperties6f23c[$name];

            if ($object instanceof $expectedType) {
                return isset($this->$name);
            }

            $class = isset($caller['class']) ? $caller['class'] : '';

            if ($class === $expectedType || is_subclass_of($class, $expectedType)) {
                return isset($this->$name);
            }
        } else {
            // check private property access via same class
            $callers = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller  = isset($callers[1]) ? $callers[1] : [];
            $class   = isset($caller['class']) ? $caller['class'] : '';

            static $accessorCache = [];

            if (isset(self::$privateProperties1c209[$name][$class])) {
                $cacheKey = $class . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function ($instance) use ($name) {
                        return isset($instance->$name);
                    }, null, $class);

                return $accessor($this);
            }

            if ('ReflectionProperty' === $class) {
                $tmpClass = key(self::$privateProperties1c209[$name]);
                $cacheKey = $tmpClass . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function ($instance) use ($name) {
                        return isset($instance->$name);
                    }, null, $tmpClass);

                return $accessor($this);
            }
        }

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this;

            return isset($targetObject->$name);
        }

        $targetObject = $realInstanceReflection->newInstanceWithoutConstructor();
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer3af7d && $this->callInitializer54965('__unset', array('name' => $name));

        if (isset(self::$publicPropertiesbb9cc[$name])) {
            unset($this->$name);

            return;
        }

        if (isset(self::$protectedProperties6f23c[$name])) {
            // check protected property access via compatible class
            $callers      = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller       = isset($callers[1]) ? $callers[1] : [];
            $object       = isset($caller['object']) ? $caller['object'] : '';
            $expectedType = self::$protectedProperties6f23c[$name];

            if ($object instanceof $expectedType) {
                unset($this->$name);

                return;
            }

            $class = isset($caller['class']) ? $caller['class'] : '';

            if ($class === $expectedType || is_subclass_of($class, $expectedType) || $class === 'ReflectionProperty') {
                unset($this->$name);

                return;
            }
        } elseif (isset(self::$privateProperties1c209[$name])) {
            // check private property access via same class
            $callers = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller  = isset($callers[1]) ? $callers[1] : [];
            $class   = isset($caller['class']) ? $caller['class'] : '';

            static $accessorCache = [];

            if (isset(self::$privateProperties1c209[$name][$class])) {
                $cacheKey = $class . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function ($instance) use ($name) {
                        unset($instance->$name);
                    }, null, $class);

                return $accessor($this);
            }

            if ('ReflectionProperty' === $class) {
                $tmpClass = key(self::$privateProperties1c209[$name]);
                $cacheKey = $tmpClass . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function ($instance) use ($name) {
                        unset($instance->$name);
                    }, null, $tmpClass);

                return $accessor($this);
            }
        }

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $realInstanceReflection->newInstanceWithoutConstructor();
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializer3af7d && $this->callInitializer54965('__clone', []);
    }

    public function __sleep()
    {
        $this->initializer3af7d && $this->callInitializer54965('__sleep', []);

        return array_keys((array) $this);
    }

    public function setProxyInitializer(?\Closure $initializer = null): void
    {
        $this->initializer3af7d = $initializer;
    }

    public function getProxyInitializer(): ?\Closure
    {
        return $this->initializer3af7d;
    }

    public function initializeProxy(): bool
    {
        return $this->initializer3af7d && $this->callInitializer54965('initializeProxy', []);
    }

    public function isProxyInitialized(): bool
    {
        return ! $this->initializer3af7d;
    }
}
