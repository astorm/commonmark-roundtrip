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

namespace Pulsestorm\CommonMark\Inline\Renderer;

use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Code;
use League\CommonMark\Util\Xml;

final class CodeRenderer implements InlineRendererInterface
{
    /**
     * @param Code                     $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Code)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }

//         $attrs = $inline->getData('attributes', []);
//
//         return new HtmlElement('code', $attrs, Xml::escape($inline->getContent()));
        return '`' . $inline->getContent() . '`';
    }
}
