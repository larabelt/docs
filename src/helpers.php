<?php

use Belt\Content\Attachment;
use Belt\Content\Helpers\ClipHelper;

if (!function_exists('clip')) {
    /**
     * @codeCoverageIgnore
     */
    function clip(Attachment $attachment)
    {
        return new ClipHelper($attachment);
    }
}