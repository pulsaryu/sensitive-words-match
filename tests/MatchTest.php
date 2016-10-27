<?php

use PHPUnit\Framework\TestCase;
use Pulsaryu\SensitiveWordMatch\Match;
use Pulsaryu\SensitiveWordMatch\Tree;

class MatchTest extends TestCase
{

    public function testTree()
    {
        $match = new Match();
        $tree = $match->createTree(['abc', 'acd', 'def']);
        $this->assertNotNull($tree);
        $this->assertNotEmpty($tree->getChildren());
        return $tree;
    }

    /**
     * @param Tree $tree
     * @depends testTree
     */
    public function testPass(Tree $tree)
    {
        $match = new Match();
        $this->assertTrue($match->check($tree, 'aabcdef'));
    }
}