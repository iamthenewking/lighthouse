<?php

namespace Nuwave\Lighthouse\Schema\Directives;

use BadMethodCallException;
use Nuwave\Lighthouse\Exceptions\DefinitionException;
use Nuwave\Lighthouse\Support\Contracts\ArgBuilderDirective;

class ScopeDirective extends BaseDirective implements ArgBuilderDirective
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'SDL'
"""
Adds a scope to the query builder.

The scope method will receive the client-given value of the argument as the second parameter.
"""
directive @scope(
  """
  The name of the scope.
  """
  name: String
) repeatable on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
SDL;
    }

    /**
     * Add additional constraints to the builder based on the given argument value.
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     *
     * @throws \Nuwave\Lighthouse\Exceptions\DefinitionException
     */
    public function handleBuilder($builder, $value): object
    {
        $scope = $this->directiveArgValue('name');
        try {
            return $builder->{$scope}($value);
        } catch (BadMethodCallException $exception) {
            throw new DefinitionException(
                $exception->getMessage()." in @{$this->name()} directive on {$this->nodeName()} argument.",
                $exception->getCode(),
                $exception->getPrevious()
            );
        }
    }
}
