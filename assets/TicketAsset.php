<?php

namespace copoka\support\assets;

use yii\web\AssetBundle;
// use kartik\dialog\Dialog;

class TicketAsset extends AssetBundle {
	public $sourcePath = '@vendor/copoka/yii2-ticket-support/assets/default';
	public $baseUrl = '@web';

	public $css = [
		'css/ticket-style.css',
	];
	public $js = [
	];
	public $depends = [
		'yii\bootstrap4\BootstrapAsset',
		// 'kartik\dialog\DialogAsset',
		'\rmrevin\yii\fontawesome\AssetBundle'
	];
}
