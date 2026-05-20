<?php

namespace DoctrineProxies\__PM__\App\Documents\Project;

class Generated32c2edf06a3018b0ccb8abbf70102614 extends \App\Documents\Project implements \ProxyManager\Proxy\GhostObjectInterface
{
    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializeree539 = null;

    /**
     * @var bool tracks initialization status - true while the object is initializing
     */
    private $initializationTrackere6281 = false;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiese8d9d = [
        
    ];

    /**
     * @var array[][] visibility and default value of defined properties, indexed by
     * property name and class name
     */
    private static $privatePropertiese8cd4 = [
        'project_code' => [
            'App\\Documents\\Project' => true,
        ],
        'name' => [
            'App\\Documents\\Project' => true,
        ],
        'description' => [
            'App\\Documents\\Project' => true,
        ],
        'is_active' => [
            'App\\Documents\\Project' => true,
        ],
        'created_by' => [
            'App\\Documents\\Project' => true,
        ],
        'updated_by' => [
            'App\\Documents\\Project' => true,
        ],
        'created_at' => [
            'App\\Documents\\Project' => true,
        ],
        'updated_at' => [
            'App\\Documents\\Project' => true,
        ],
    ];

    /**
     * @var string[][] declaring class name of defined protected properties, indexed by
     * property name
     */
    private static $protectedPropertiese79dd = [
        
    ];

    private static $signature32c2edf06a3018b0ccb8abbf70102614 = 'YTo0OntzOjk6ImNsYXNzTmFtZSI7czoyMToiQXBwXERvY3VtZW50c1xQcm9qZWN0IjtzOjc6ImZhY3RvcnkiO3M6NDQ6IlByb3h5TWFuYWdlclxGYWN0b3J5XExhenlMb2FkaW5nR2hvc3RGYWN0b3J5IjtzOjE5OiJwcm94eU1hbmFnZXJWZXJzaW9uIjtzOjQ4OiJ2MS4wLjE5QGMyMDI5OWFhOWY0OGE2MjIwNTI5NjRhNzVjNWE0Y2VmMDE3Mzk4YjIiO3M6MTI6InByb3h5T3B0aW9ucyI7YToxOntzOjE3OiJza2lwcGVkUHJvcGVydGllcyI7YToxOntpOjA7czoyNToiAEFwcFxEb2N1bWVudHNcUHJvamVjdABpZCI7fX19';

    /**
     * Triggers initialization logic for this ghost object
     *
     * @param string  $methodName
     * @param mixed[] $parameters
     *
     * @return mixed
     */
    private function callInitializerb99b1($methodName, array $parameters)
    {
        if ($this->initializationTrackere6281 || ! $this->initializeree539) {
            return;
        }

        $this->initializationTrackere6281 = true;

        static $cacheApp_Documents_Project;

        $cacheApp_Documents_Project ?? $cacheApp_Documents_Project = \Closure::bind(static function ($instance) {
            $instance->description = null;
            $instance->is_active = true;
            $instance->created_by = null;
            $instance->updated_by = null;
            $instance->created_at = null;
            $instance->updated_at = null;
        }, null, 'App\\Documents\\Project');

        $cacheApp_Documents_Project($this);




        $nonReferenceableProperties = new class() {
            public ?string $project_code_on_App_Documents_Project;
            public ?string $name_on_App_Documents_Project;
        };
        $properties = [
            '' . "\0" . 'App\\Documents\\Project' . "\0" . 'project_code' => & $nonReferenceableProperties->project_code_on_App_Documents_Project,
            '' . "\0" . 'App\\Documents\\Project' . "\0" . 'name' => & $nonReferenceableProperties->name_on_App_Documents_Project,
        ];

        static $cacheFetchApp_Documents_Project;

        $cacheFetchApp_Documents_Project ?? $cacheFetchApp_Documents_Project = \Closure::bind(function ($instance, array & $properties) {
            $properties['' . "\0" . 'App\\Documents\\Project' . "\0" . 'description'] = & $instance->description;
            $properties['' . "\0" . 'App\\Documents\\Project' . "\0" . 'is_active'] = & $instance->is_active;
            $properties['' . "\0" . 'App\\Documents\\Project' . "\0" . 'created_by'] = & $instance->created_by;
            $properties['' . "\0" . 'App\\Documents\\Project' . "\0" . 'updated_by'] = & $instance->updated_by;
            $properties['' . "\0" . 'App\\Documents\\Project' . "\0" . 'created_at'] = & $instance->created_at;
            $properties['' . "\0" . 'App\\Documents\\Project' . "\0" . 'updated_at'] = & $instance->updated_at;
        }, null, 'App\\Documents\\Project');

        $cacheFetchApp_Documents_Project($this, $properties);

        $result = $this->initializeree539->__invoke($this, $methodName, $parameters, $this->initializeree539, $properties);
        static $cacheAssignApp_Documents_Project;

        $cacheAssignApp_Documents_Project ?? $cacheAssignApp_Documents_Project = \Closure::bind(function ($instance, $nonReferenceableProperties) {
            isset($nonReferenceableProperties->project_code_on_App_Documents_Project) && $instance->project_code = $nonReferenceableProperties->project_code_on_App_Documents_Project;
            isset($nonReferenceableProperties->name_on_App_Documents_Project) && $instance->name = $nonReferenceableProperties->name_on_App_Documents_Project;
        }, null, 'App\\Documents\\Project');

        $cacheAssignApp_Documents_Project($this, $nonReferenceableProperties);
        $this->initializationTrackere6281 = false;

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

        \Closure::bind(function (\App\Documents\Project $instance) {
            unset($instance->project_code, $instance->name, $instance->description, $instance->is_active, $instance->created_by, $instance->updated_by, $instance->created_at, $instance->updated_at);
        }, $instance, 'App\\Documents\\Project')->__invoke($instance);

        $instance->initializeree539 = $initializer;

        return $instance;
    }

    public function & __get($name)
    {
        $this->initializeree539 && ! $this->initializationTrackere6281 && $this->callInitializerb99b1('__get', array('name' => $name));

        if (isset(self::$publicPropertiese8d9d[$name])) {
            return $this->$name;
        }

        if (isset(self::$protectedPropertiese79dd[$name])) {
            if ($this->initializationTrackere6281) {
                return $this->$name;
            }

            // check protected property access via compatible class
            $callers      = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller       = isset($callers[1]) ? $callers[1] : [];
            $object       = isset($caller['object']) ? $caller['object'] : '';
            $expectedType = self::$protectedPropertiese79dd[$name];

            if ($object instanceof $expectedType) {
                return $this->$name;
            }

            $class = isset($caller['class']) ? $caller['class'] : '';

            if ($class === $expectedType || is_subclass_of($class, $expectedType) || $class === 'ReflectionProperty') {
                return $this->$name;
            }
        } elseif (isset(self::$privatePropertiese8cd4[$name])) {
            // check private property access via same class
            $callers = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller  = isset($callers[1]) ? $callers[1] : [];
            $class   = isset($caller['class']) ? $caller['class'] : '';

            static $accessorCache = [];

            if (isset(self::$privatePropertiese8cd4[$name][$class])) {
                $cacheKey = $class . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function & ($instance) use ($name) {
                        return $instance->$name;
                    }, null, $class);

                return $accessor($this);
            }

            if ($this->initializationTrackere6281 || 'ReflectionProperty' === $class) {
                $tmpClass = key(self::$privatePropertiese8cd4[$name]);
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
        $this->initializeree539 && $this->callInitializerb99b1('__set', array('name' => $name, 'value' => $value));

        if (isset(self::$publicPropertiese8d9d[$name])) {
            return ($this->$name = $value);
        }

        if (isset(self::$protectedPropertiese79dd[$name])) {
            // check protected property access via compatible class
            $callers      = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller       = isset($callers[1]) ? $callers[1] : [];
            $object       = isset($caller['object']) ? $caller['object'] : '';
            $expectedType = self::$protectedPropertiese79dd[$name];

            if ($object instanceof $expectedType) {
                return ($this->$name = $value);
            }

            $class = isset($caller['class']) ? $caller['class'] : '';

            if ($class === $expectedType || is_subclass_of($class, $expectedType) || $class === 'ReflectionProperty') {
                return ($this->$name = $value);
            }
        } elseif (isset(self::$privatePropertiese8cd4[$name])) {
            // check private property access via same class
            $callers = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller  = isset($callers[1]) ? $callers[1] : [];
            $class   = isset($caller['class']) ? $caller['class'] : '';

            static $accessorCache = [];

            if (isset(self::$privatePropertiese8cd4[$name][$class])) {
                $cacheKey = $class . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function ($instance, $value) use ($name) {
                        return ($instance->$name = $value);
                    }, null, $class);

                return $accessor($this, $value);
            }

            if ('ReflectionProperty' === $class) {
                $tmpClass = key(self::$privatePropertiese8cd4[$name]);
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
        $this->initializeree539 && $this->callInitializerb99b1('__isset', array('name' => $name));

        if (isset(self::$publicPropertiese8d9d[$name])) {
            return isset($this->$name);
        }

        if (isset(self::$protectedPropertiese79dd[$name])) {
            // check protected property access via compatible class
            $callers      = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller       = isset($callers[1]) ? $callers[1] : [];
            $object       = isset($caller['object']) ? $caller['object'] : '';
            $expectedType = self::$protectedPropertiese79dd[$name];

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

            if (isset(self::$privatePropertiese8cd4[$name][$class])) {
                $cacheKey = $class . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function ($instance) use ($name) {
                        return isset($instance->$name);
                    }, null, $class);

                return $accessor($this);
            }

            if ('ReflectionProperty' === $class) {
                $tmpClass = key(self::$privatePropertiese8cd4[$name]);
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
        $this->initializeree539 && $this->callInitializerb99b1('__unset', array('name' => $name));

        if (isset(self::$publicPropertiese8d9d[$name])) {
            unset($this->$name);

            return;
        }

        if (isset(self::$protectedPropertiese79dd[$name])) {
            // check protected property access via compatible class
            $callers      = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller       = isset($callers[1]) ? $callers[1] : [];
            $object       = isset($caller['object']) ? $caller['object'] : '';
            $expectedType = self::$protectedPropertiese79dd[$name];

            if ($object instanceof $expectedType) {
                unset($this->$name);

                return;
            }

            $class = isset($caller['class']) ? $caller['class'] : '';

            if ($class === $expectedType || is_subclass_of($class, $expectedType) || $class === 'ReflectionProperty') {
                unset($this->$name);

                return;
            }
        } elseif (isset(self::$privatePropertiese8cd4[$name])) {
            // check private property access via same class
            $callers = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $caller  = isset($callers[1]) ? $callers[1] : [];
            $class   = isset($caller['class']) ? $caller['class'] : '';

            static $accessorCache = [];

            if (isset(self::$privatePropertiese8cd4[$name][$class])) {
                $cacheKey = $class . '#' . $name;
                $accessor = isset($accessorCache[$cacheKey])
                    ? $accessorCache[$cacheKey]
                    : $accessorCache[$cacheKey] = \Closure::bind(static function ($instance) use ($name) {
                        unset($instance->$name);
                    }, null, $class);

                return $accessor($this);
            }

            if ('ReflectionProperty' === $class) {
                $tmpClass = key(self::$privatePropertiese8cd4[$name]);
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
        $this->initializeree539 && $this->callInitializerb99b1('__clone', []);
    }

    public function __sleep()
    {
        $this->initializeree539 && $this->callInitializerb99b1('__sleep', []);

        return array_keys((array) $this);
    }

    public function setProxyInitializer(?\Closure $initializer = null): void
    {
        $this->initializeree539 = $initializer;
    }

    public function getProxyInitializer(): ?\Closure
    {
        return $this->initializeree539;
    }

    public function initializeProxy(): bool
    {
        return $this->initializeree539 && $this->callInitializerb99b1('initializeProxy', []);
    }

    public function isProxyInitialized(): bool
    {
        return ! $this->initializeree539;
    }
}
