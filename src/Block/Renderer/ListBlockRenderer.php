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
use League\CommonMark\Block\Element\ListBlock;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

final class ListBlockRenderer implements BlockRendererInterface
{
    /**
     * @param ListBlock                $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return HtmlElement
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof ListBlock)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

//         $listData = $block->getListData();
//
//         $tag = $listData->type === ListBlock::TYPE_UNORDERED ? 'ul' : 'ol';
//
//         $attrs = $block->getData('attributes', []);
//
//         if ($listData->start !== null && $listData->start !== 1) {
//             $attrs['start'] = (string) $listData->start;
//         }
//
//         return new HtmlElement(
//             $tag,
//             $attrs,
//             $htmlRenderer->getOption('inner_separator', "\n") . $htmlRenderer->renderBlocks(
//                 $block->children(),
//                 $block->isTight()
//             ) . $htmlRenderer->getOption('inner_separator', "\n")
//         );
// var_dump(get_class($htmlRenderer));
            $listData = $block->getListData();

            $listId = uniqid();
            $renderingInfo = [
                'id'=>$listId,
                'count'=>1,
                'type'=>$listData->type
            ];
            self::addCurrentlyRenering($renderingInfo);
            $content = $htmlRenderer->renderBlocks(
                $block->children(),
                $block->isTight()
            );
            if($block->isTight()) {
                $content .= "\n";
            }
            self::popCurrentlyRenering();
            return $content;
    }

    static private $currentListType=[];
    static public function getCurrentlyRenering() {
        return end(self::$currentListType);
    }
    static public function addCurrentlyRenering($type) {
        self::$currentListType[] = $type;
    }
    static public function popCurrentlyRenering() {
        return array_pop(self::$currentListType);
    }
    static public function incrementCount($renderingInfo) {
        for($i=0;$i<count(self::$currentListType);$i++) {
            $data = self::$currentListType[$i];
            if($data['id'] === $renderingInfo['id']) {
                self::$currentListType[$i]['count']++;
            }
        }
    }
}
