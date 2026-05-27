<?php

namespace DoctrineProxies\__PM__\App\Documents\WorkFlowStages;

class Generated65998de87b399821b322e46d62e1e7b4 extends \App\Documents\WorkFlowStages implements \ProxyManager\Proxy\GhostObjectInterface
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
        'workflow_template' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'stage_name' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'stage_order' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'department' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'role' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'can_skip' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'can_rework' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'is_mandatory' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'is_final_stage' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'sla_hours' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'is_active' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'created_by' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'updated_by' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'created_at' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
        'updated_at' => [
            'App\\Documents\\WorkFlowStages' => true,
        ],
    ];

    /**
     * @var string[][] declaring class name of defined protected properties, indexed by
     * property name
     */
    private static $protectedPropertiese79dd = [
        
    ];

    private static $signature65998de87b399821b322e46d62e1e7b4 = 'YTo0OntzOjk6ImNsYXNzTmFtZSI7czoyODoiQXBwXERvY3VtZW50c1xXb3JrRmxvd1N0YWdlcyI7czo3OiJmYWN0b3J5IjtzOjQ0OiJQcm94eU1hbmFnZXJcRmFjdG9yeVxMYXp5TG9hZGluZ0dob3N0RmFjdG9yeSI7czoxOToicHJveHlNYW5hZ2VyVmVyc2lvbiI7czo0ODoidjEuMC4xOUBjMjAyOTlhYTlmNDhhNjIyMDUyOTY0YTc1YzVhNGNlZjAxNzM5OGIyIjtzOjEyOiJwcm94eU9wdGlvbnMiO2E6MTp7czoxNzoic2tpcHBlZFByb3BlcnRpZXMiO2E6MTp7aTowO3M6MzI6IgBBcHBcRG9jdW1lbnRzXFdvcmtGbG93U3RhZ2VzAGlkIjt9fX0=';

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

        static $cacheApp_Documents_WorkFlowStages;

        $cacheApp_Documents_WorkFlowStages ?? $cacheApp_Documents_WorkFlowStages = \Closure::bind(static function ($instance) {
            $instance->workflow_template = null;
            $instance->department = null;
            $instance->role = null;
            $instance->can_skip = false;
            $instance->can_rework = false;
            $instance->is_mandatory = true;
            $instance->is_final_stage = false;
            $instance->sla_hours = null;
            $instance->is_active = true;
            $instance->created_by = null;
            $instance->updated_by = null;
            $instance->created_at = null;
            $instance->updated_at = null;
        }, null, 'App\\Documents\\WorkFlowStages');

        $cacheApp_Documents_WorkFlowStages($this);




        $nonReferenceableProperties = new class() {
            public ?string $stage_name_on_App_Documents_WorkFlowStages;
            public ?int $stage_order_on_App_Documents_WorkFlowStages;
        };
        $properties = [
            '' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'stage_name' => & $nonReferenceableProperties->stage_name_on_App_Documents_WorkFlowStages,
            '' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'stage_order' => & $nonReferenceableProperties->stage_order_on_App_Documents_WorkFlowStages,
        ];

        static $cacheFetchApp_Documents_WorkFlowStages;

        $cacheFetchApp_Documents_WorkFlowStages ?? $cacheFetchApp_Documents_WorkFlowStages = \Closure::bind(function ($instance, array & $properties) {
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'workflow_template'] = & $instance->workflow_template;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'department'] = & $instance->department;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'role'] = & $instance->role;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'can_skip'] = & $instance->can_skip;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'can_rework'] = & $instance->can_rework;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'is_mandatory'] = & $instance->is_mandatory;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'is_final_stage'] = & $instance->is_final_stage;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'sla_hours'] = & $instance->sla_hours;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'is_active'] = & $instance->is_active;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'created_by'] = & $instance->created_by;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'updated_by'] = & $instance->updated_by;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'created_at'] = & $instance->created_at;
            $properties['' . "\0" . 'App\\Documents\\WorkFlowStages' . "\0" . 'updated_at'] = & $instance->updated_at;
        }, null, 'App\\Documents\\WorkFlowStages');

        $cacheFetchApp_Documents_WorkFlowStages($this, $properties);

        $result = $this->initializeree539->__invoke($this, $methodName, $parameters, $this->initializeree539, $properties);
        static $cacheAssignApp_Documents_WorkFlowStages;

        $cacheAssignApp_Documents_WorkFlowStages ?? $cacheAssignApp_Documents_WorkFlowStages = \Closure::bind(function ($instance, $nonReferenceableProperties) {
            isset($nonReferenceableProperties->stage_name_on_App_Documents_WorkFlowStages) && $instance->stage_name = $nonReferenceableProperties->stage_name_on_App_Documents_WorkFlowStages;
            isset($nonReferenceableProperties->stage_order_on_App_Documents_WorkFlowStages) && $instance->stage_order = $nonReferenceableProperties->stage_order_on_App_Documents_WorkFlowStages;
        }, null, 'App\\Documents\\WorkFlowStages');

        $cacheAssignApp_Documents_WorkFlowStages($this, $nonReferenceableProperties);
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

        \Closure::bind(function (\App\Documents\WorkFlowStages $instance) {
            unset($instance->workflow_template, $instance->stage_name, $instance->stage_order, $instance->department, $instance->role, $instance->can_skip, $instance->can_rework, $instance->is_mandatory, $instance->is_final_stage, $instance->sla_hours, $instance->is_active, $instance->created_by, $instance->updated_by, $instance->created_at, $instance->updated_at);
        }, $instance, 'App\\Documents\\WorkFlowStages')->__invoke($instance);

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
