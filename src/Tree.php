<?php

namespace Pulsaryu\SensitiveWordMatch;


class Tree
{
    private $test;
    private $children = [];

    public function __construct($text)
    {
        $this->test = $text;
    }

    public function addChild(Tree $child)
    {
        $this->children[] = $child;
    }

    public function getText()
    {
        return $this->test;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getChildByText($text)
    {
        /** @var Tree $child */
        foreach ($this->children as $child) {
            if ($child->getText() == $text) {
                return $child;
            }
        }

        return null;
    }
}