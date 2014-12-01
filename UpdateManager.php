<?php

namespace fishvision\updatemanager;

use yii\helpers\Html;
use yii\web\View;

/**
 * Class UpdateManager
 * @package fishvision\updatemanager
 */
class UpdateManager
{
    /**
     * Positions where the updates should be appended to
     */
    const POSITION_START = 1;
    const POSITION_END = 2;

    /**
     * @var
     */
    private $view;

    /**
     * @param $view
     */
    public function __construct($view)
    {
        $this->view = $view;
    }

    /**
     * @param $checkUrl
     * @param $updateUrl
     * @param $container
     * @param bool $append
     * @param int $step
     * @param int $position
     */
    public function monitor(
        $checkUrl,
        $updateUrl,
        $container,
        $append = false,
        $step = 5000,
        $position = self::POSITION_END
    ) {
        // Format the javascript code to be outputted
        $js = sprintf("var UPDATEMANAGER_POSITION_START = %d; var UPDATEMANAGER_POSITION_END = %d;\n",
            self::POSITION_START, self::POSITION_END);
        $this->view->registerJs($js, View::POS_HEAD);

        $js = sprintf('var conversationThread = new UpdateManager("%s", "%s", "%s", %b, %d); conversationThread.start(%d);',
            Html::encode($checkUrl), Html::encode($updateUrl), Html::encode($container), $append, $position, $step);

        // Register the js
        $this->view->registerJs($js);
    }
}