<?php
/**
 * commerce-paytrace plugin for Craft CMS 3.x
 *
 * Craft Commerce 2 Payment Gateway for PayTrace
 *
 * @link      https://github.com/unionco
 * @copyright Copyright (c) 2019 UNION
 */

namespace unionco\paytrace\assetbundles\PayTrace;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    UNION
 * @package   PayTrace
 * @since     0.0.1
 */
class PayTraceAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@unionco/paytrace/assetbundles/paytrace/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/PayTrace.js',
        ];

        $this->css = [
            'css/PayTrace.css',
        ];

        parent::init();
    }
}
