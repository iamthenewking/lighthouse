<?php

namespace Nuwave\Lighthouse\Schema\Values;

use GraphQL\Language\AST\DirectiveNode;
use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\Type;

class NodeValue
{
    /**
     * Current GraphQL type.
     *
     * @var Type
     */
    protected $type;

    /**
     * Current definition node.
     *
     * @var Node
     */
    protected $node;

    /**
     * Node directive.
     *
     * @var DirectiveNode
     */
    protected $directive;

    /**
     * Create new instance of node value.
     *
     * @param Node $node
     */
    public function __construct(Node $node)
    {
        $this->node = $node;
    }

    /**
     * Create new instance of node value.
     *
     * @param Node $node
     */
    public static function init(Node $node)
    {
        return new static($node);
    }

    /**
     * Set type definition.
     *
     * @param Type $type
     *
     * @return self
     */
    public function setType(Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the current directive.
     *
     * @param DirectiveNode $directive
     */
    public function setDirective(DirectiveNode $directive)
    {
        $this->directive = $directive;
    }

    /**
     * Get current node.
     *
     * @return Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Get current directive.
     *
     * @return DirectiveNode|null
     */
    public function getDirective()
    {
        return $this->directive;
    }

    /**
     * Get resolved type.
     *
     * @return Type|null
     */
    public function getType()
    {
        return $this->type;
    }
}