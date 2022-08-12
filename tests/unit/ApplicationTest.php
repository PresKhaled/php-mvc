<?php

namespace Tests\unit;

use App\Application;
use App\Session;
use Khaled\PhpMvc\database\DB;
use Khaled\PhpMvc\http\Connection;
use Khaled\PhpMvc\http\Response;
use Khaled\PhpMvc\http\Route;
use Minwork\Helper\Arr;
use ReflectionClass;
use ReflectionProperty;
use Tests\CustomTestCase;

class ApplicationTest extends CustomTestCase
{
    /** @test */
    public function it_has_a_constructor()
    {
        $application = new Application;
        $applicationConstructor = (new ReflectionClass($application))->getConstructor();

        $this->assertTrue($applicationConstructor->isConstructor());
    }

    /** @test */
    public function ensure_that_the_mandatory_properties_are_exists()
    {
        $application = new Application;
        $applicationReflection = new ReflectionClass($application);
        $mandatoryProperties = ['connection', 'response', 'session', 'route', 'database'];
        $notPublicProperties = ['route'];
        $mandatoryPropertiesTypes = [Connection::class, Response::class, Session::class, Route::class, DB::class];

        // Check the availability of the mandatory properties.
        Arr::each(
            $mandatoryProperties,
            fn(string $name) => $this->assertTrue($applicationReflection->hasProperty($name))
        );

        $properties = $applicationReflection->getProperties();

        // Ensure that the properties are public, read-only, and their types are valid and initialized.
        Arr::each(
            $properties,
            fn(ReflectionProperty $property) => $this->assertTrue(
                (($property->isPublic() xor in_array($property->name, $notPublicProperties))
                    && $property->isReadOnly()
                    && in_array($property->getType()->getName(), $mandatoryPropertiesTypes)
                    && $property->isInitialized($application))
            )
        );
    }
}
