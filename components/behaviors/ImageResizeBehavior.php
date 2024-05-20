<?php

namespace app\components\behaviors;

use app\components\Image;
use app\models\articles\Articles;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class ImageResizeBehavior extends Behavior
{
    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_AFTER_FIND => 'resizeImage',
        ];
    }

    public function resizeImage($event)
    {
        $this->owner->caption = Image::resize($this->owner->image,
        Articles::CAPTION_SIZE_WIDTH,
        Articles::CAPTION_SIZE_HEIGHT);
    }
}