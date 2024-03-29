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

use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\Block\Element\ListBlock;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\ListItem;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

use Pulsestorm\CommonMark\Block\Renderer\ListBlockRenderer;

final class ListItemRenderer implements BlockRendererInterface
{
    /**
     * @param ListItem                 $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return string
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof ListItem)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

//         $contents = $htmlRenderer->renderBlocks($block->children(), $inTightList);
//         if (\substr($contents, 0, 1) === '<') {
//             $contents = "\n" . $contents;
//         }
//         if (\substr($contents, -1, 1) === '>') {
//             $contents .= "\n";
//         }
//
//         $attrs = $block->getData('attributes', []);
//
//         $li = new HtmlElement('li', $attrs, $contents);
//
//         return $li;
        $bullet = '- ';
        $rendering = ListBlockRenderer::getCurrentlyRenering();
        if(ListBlock::TYPE_ORDERED == $rendering['type']) {
            $count = $rendering['count'];
            $bullet = $count . '. ';
            ListBlockRenderer::incrementCount($rendering);
        }

        $extraLineEnding = $inTightList ? '' : "\n";
        return $bullet . trim($htmlRenderer->renderBlocks($block->children(), $inTightList)) . $extraLineEnding;

    }
}
