<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (https://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pulsestorm\CommonMark\Block\Renderer;
use Pulsestorm\CommonMark\Util\Xml;

use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Paragraph;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

final class ParagraphRenderer implements BlockRendererInterface
{
    /**
     * @param Paragraph                $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return HtmlElement|string
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof Paragraph)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

//         if ($inTightList) {
//             return $htmlRenderer->renderInlines($block->children());
//         }
//
//         $attrs = $block->getData('attributes', []);
//
//         return new HtmlElement('p', $attrs, $htmlRenderer->renderInlines($block->children()));
        return Xml::unescape($htmlRenderer->renderInlines($block->children())) . "\n";
    }
}
