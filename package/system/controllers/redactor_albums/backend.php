<?php

class backendRedactor_albums extends cmsBackend {

    public $useDefaultOptionsAction = true;

    protected $useOptions = true;
		

    public function actionIndex(){
        $this->redirectToAction('options');
    }

}
