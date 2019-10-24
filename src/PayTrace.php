<?php
/**
 * commerce-paytrace plugin for Craft CMS 3.x
 *
 * Craft Commerce 2 Payment Gateway for PayTrace
 *
 * @link      https://github.com/unionco
 * @copyright Copyright (c) 2019 UNION
 */

namespace unionco\paytrace;

use Craft;
use craft\base\Plugin;
use craft\commerce\services\Gateways;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\events\RegisterComponentTypesEvent;
use unionco\paytrace\gateways\PayTrace as PayTraceGateway;
use unionco\paytrace\services\Omnipay;
use yii\base\Event;

/**
 * Class PayTrace
 *
 * @author    UNION
 * @package   PayTrace
 * @since     0.0.1
 *
 */
class PayTrace extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var PayTrace
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '0.0.1';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->_initializePlugin();
        $this->_registerComponents();
        $this->_registerGateways();
    }

    // Settings are provided at the Gateway level
    // // Protected Methods
    // // =========================================================================

    // /**
    //  * @inheritdoc
    //  */
    // protected function createSettingsModel()
    // {
    //     return new Settings();
    // }

    // /**
    //  * @inheritdoc
    //  */
    // protected function settingsHtml(): string
    // {
    //     return Craft::$app->view->renderTemplate(
    //         'commerce-paytrace/settings',
    //         [
    //             'settings' => $this->getSettings()
    //         ]
    //     );
    // }

    // Private Methods
    // =========================================================================
    /**
     * @return void
     */
    private function _initializePlugin()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'commerce-paytrace',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    /**
     * @return void
     */
    private function _registerComponents()
    {
        $this->setComponents([
            'omnipay' => Omnipay::class,
        ]);
    }

    /**
     * @return void
     */
    private function _registerGateways()
    {
        Event::on(
            Gateways::class,
            Gateways::EVENT_REGISTER_GATEWAY_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = PayTraceGateway::class;
            }
        );
    }
}
