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

namespace LINE\LINEBot\MessageBuilder;

use LINE\LINEBot\Constant\MessageType;
use LINE\LINEBot\MessageBuilder;

/**
 * A builder class for video message.
 *
 * @package LINE\LINEBot\MessageBuilder
 */
class VideoMessageBuilder implements MessageBuilder
{
    /** @var string */
    private $originalContentUrl;
    /** @var string */
    private $previewImageUrl;
    /** @var array */
    private $quickReplys;

    /**
     * VideoMessageBuilder constructor.
     *
     * @param string $originalContentUrl
     * @param string $previewImageUrl
     */
    public function __construct($originalContentUrl, $previewImageUrl,$quickReplys=array())
    {
        $this->originalContentUrl = $originalContentUrl;
        $this->previewImageUrl = $previewImageUrl;
        $this->quickReplys = $quickReplys;
    }

    /**
     * Builds video message structure.
     *
     * @return array
     */
    public function buildMessage()
    {
        $actions = array();
        if (!empty($this->quickReplys)) {
            foreach ($this->quickReplys as $key => $action) {
                $actions[] = [
                    'type' => 'action',
                    'imageUrl' => $action["icon"],
                    'action' => $action["action"]->buildTemplateAction()
                ];
            }
        }
        $message = [
            [
                'type' => MessageType::VIDEO,
                'originalContentUrl' => $this->originalContentUrl,
                'previewImageUrl' => $this->previewImageUrl,
            ]
        ];
        if (!empty($actions)) {
            $message['quickReply']['items'] = $actions;
        }
        return [$message];
    }
}
