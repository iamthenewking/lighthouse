<?php

namespace Tests\Unit\Console;

use Tests\TestCase;
use Nuwave\Lighthouse\Console\IdeHelperCommand;
use Nuwave\Lighthouse\Schema\Directives\FieldDirective;

class IdeHelperCommandTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        /** @var \Illuminate\Contracts\Config\Repository $config */
        $config = $app['config'];

        $config->set('lighthouse.namespaces.directives', [
            'Tests\\Unit\\Console',
        ]);
    }

    /**
     * @test
     */
    public function itGeneratesSchemaDirectives(): void
    {
        $this->artisan('lighthouse:ide-helper');

        $this->assertFileExists(IdeHelperCommand::filePath());
        $generated = file_get_contents(IdeHelperCommand::filePath());

        $this->assertStringStartsWith(IdeHelperCommand::GENERATED_NOTICE, $generated);
        $this->assertStringEndsWith("\n", $generated);

        $this->assertStringContainsString(
            FieldDirective::definition(),
            $generated,
            'Generates definition for built-in directives'
        );
        $this->assertStringContainsString(FieldDirective::class, $generated);

        $this->assertStringContainsString(
            UnionDirective::definition(),
            $generated,
            'Overwrites definitions through custom namespaces'
        );
        $this->assertStringContainsString(UnionDirective::class, $generated);
    }
}
