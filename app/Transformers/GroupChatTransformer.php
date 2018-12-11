<?php

namespace App\Transformers;

use App\GroupChat;
use League\Fractal\TransformerAbstract;

class GroupChatTransformer extends TransformerAbstract
{
    private $detail;

    public function __construct($detail = false)
    {
        $this->detail = $detail;
    }

    /**
     * A Fractal transformer.
     *
     * @param \App\GroupChat $groupChat
     * @return array
     */
    public function transform(GroupChat $groupChat)
    {
        if ($this->detail) {
            return $groupChat->toAll();
        }

        return $groupChat->toOriginal();
    }
}
