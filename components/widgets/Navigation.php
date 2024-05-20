<?php

namespace app\components\widgets;

use app\models\category\Category;
use yii\base\Widget;

class Navigation extends Widget
{
    public function run()
    {
        $model = new Category();
        return $this->render( 'navigation', ['models' => $model->getTree()]);
    }

}