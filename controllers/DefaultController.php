<?php

namespace powerkernel\support\controllers;

use backend\controllers\BackendController;

/**
 * Default controller for the `ticket` module
 */
class DefaultController extends BackendController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
