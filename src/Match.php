<?php

namespace Pulsaryu\SensitiveWordMatch;


class Match
{
    public function createTree($words)
    {
        $root = new Tree(null);
        foreach ($words as $word) {
            $current = $root;
            $split = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($split as $item) {
                $child = $current->getChildByText($item);
                if ($child) {
                    $current = $child;
                } else {
                    $tree = new Tree($item);
                    $current->addChild($tree);
                    $current = $tree;
                }
            }
        }
        return $root;
    }

    public function check(Tree $tree, $doc, $pp = -1)
    {
        $children = $tree->getChildren();

        if (empty($children)) {
            return $pp !== -1;
        }

        /** @var Tree $child */
        foreach ($children as $child) {
            $text = $child->getText();

            if ($pp == -1) {
                $end = false;
                $lp = 0;
                do {
                    $p = stripos($doc, $text, $lp);
                    $lp = $p + 1;
                    if ($p !== false) {
                        if ($this->check($child, $doc, $p + strlen($text))) {
                            return true;
                        }
                    } else {
                        $end = true;
                    }
                } while (!$end);
            } else {
                $nt = substr($doc, $pp, strlen($text));
                if ($nt == $text) {
                    if ($this->check($child, $doc, $pp + strlen($text))) {
                        return true;
                    }
                }
            }

        }

        return false;
    }
}