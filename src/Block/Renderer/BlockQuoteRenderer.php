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
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\BlockQuote;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

final class BlockQuoteRenderer implements BlockRendererInterface
{
    /**
     * @param BlockQuote               $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return HtmlElement
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof BlockQuote)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

        $attrs = $block->getData('attributes', []);

        $filling = $htmlRenderer->renderBlocks($block->children());
        if ($filling === '') {
            return new HtmlElement('blockquote', $attrs, $htmlRenderer->getOption('inner_separator', "\n"));
        }

        return new HtmlElement(
            'blockquote',
            $attrs,
            $htmlRenderer->getOption('inner_separator', "\n") . $filling . $htmlRenderer->getOption('inner_separator', "\n")
        );
    }
}
