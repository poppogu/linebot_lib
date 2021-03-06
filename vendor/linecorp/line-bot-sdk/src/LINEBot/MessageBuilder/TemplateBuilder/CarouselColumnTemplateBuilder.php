<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace LINE\LINEBot\MessageBuilder\TemplateBuilder;

use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder;

/**
 * A builder class for column of carousel template.
 *
 * @package LINE\LINEBot\MessageBuilder\TemplateBuilder
 */
class CarouselColumnTemplateBuilder implements TemplateBuilder
{
    /** @var string */
    private $title;
    /** @var string */
    private $text;
    /** @var string */
    private $thumbnailImageUrl;
    /** @var TemplateActionBuilder[] */
    private $actionBuilders;
    /** @var TemplateActionBuilder */
    private $defaultActionBuilder;

    /** @var array */
    private $template;

    /**
     * CarouselColumnTemplateBuilder constructor.
     *
     * @param string $title
     * @param string $text
     * @param string $thumbnailImageUrl
     * @param TemplateActionBuilder[] $actionBuilders
     */
    public function __construct($title, $text, $thumbnailImageUrl, array $actionBuilders, $defaultActionBuilder="")
    {
        $this->title = $title;
        $this->text = $text;
        $this->thumbnailImageUrl = $thumbnailImageUrl;
        $this->actionBuilders = $actionBuilders;
        $this->defaultActionBuilder = $defaultActionBuilder;
    }

    /**
     * Builds column of carousel template structure.
     *
     * @return array
     */
    public function buildTemplate()
    {
        if (!empty($this->template)) {
            return $this->template;
        }

        $actions = [];
        foreach ($this->actionBuilders as $actionBuilder) {
            $actions[] = $actionBuilder->buildTemplateAction();
        }

        $this->template = [
            'text' => $this->text,
            'actions' => $actions,
        ];

        if (!empty($this->title)) {
            $this->template['title'] = $this->title;
        }

        if (!empty($this->thumbnailImageUrl)) {
            $this->template['thumbnailImageUrl'] = $this->thumbnailImageUrl;
        }

        if (!empty($this->defaultActionBuilder)) {
            $this->template['defaultAction'] = $this->defaultActionBuilder->buildTemplateAction();;
        }

        return $this->template;
    }
}
