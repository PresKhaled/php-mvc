<?php

namespace Tests\unit;

use App\View;
use ReflectionClass;
use Tests\CustomTestCase;

class ViewTest extends CustomTestCase
{
    protected static ReflectionClass $viewReflection;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$viewReflection = new ReflectionClass(new View);
    }

    /** @test */
    public function ensure_the_layout_is_exist()
    {
       $getLayout = self::$viewReflection->getMethod('getLayout');

        $getLayout->setAccessible(true);

       $layoutHtml = $getLayout->invoke(null);

       $this->assertTrue($layoutHtml !== strip_tags($layoutHtml)); // Ensure the value is HTML.
       $this->assertStringContainsString('{{CONTENT}}', $layoutHtml);
    }

    /** @test */
    public function ensure_the_view_is_rendered_with_parameters()
    {
        $getViewContent = self::$viewReflection->getMethod('getViewContent');

        $getViewContent->setAccessible(true);

        $viewContentHtml = $getViewContent->invoke(
            null,
            view_path('misc.invoked'),
            ['fragranceType' => 'Vanilla'],
        );

        $this->assertTrue($viewContentHtml !== strip_tags($viewContentHtml)); // Ensure the value is HTML.
        $this->assertStringContainsString('Vanilla', $viewContentHtml);
    }

    /** @test */
    public function it_must_return_view()
    {
        $view = html_entity_decode(View::make('misc.invoked', ['fragranceType' => 'Vanilla']));

        $this->assertTrue($view !== strip_tags($view)); // Ensure the value is HTML.
        $this->assertStringNotContainsString('{{CONTENT}}', $view);
        $this->assertStringContainsString('Vanilla', $view);
    }
}
