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
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Util\Xml;

final class FencedCodeRenderer implements BlockRendererInterface
{
    /**
     * @param FencedCode               $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return HtmlElement
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof FencedCode)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

//         $attrs = $block->getData('attributes', []);
//
//         $infoWords = $block->getInfoWords();
//         if (count($infoWords) !== 0 && \strlen($infoWords[0]) !== 0) {
//             $attrs['class'] = isset($attrs['class']) ? $attrs['class'] . ' ' : '';
//             $attrs['class'] .= 'language-' . $infoWords[0];
//         }
//
//         return new HtmlElement(
//             'pre',
//             [],
//             new HtmlElement('code', $attrs, Xml::escape($block->getStringContent()))
//         );
        $infoWords = $block->getInfoWords();

        return '```' . implode(' ', $infoWords) . "\n" . $block->getStringContent() . '```' . "\n";
    }
}
