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

use unionco\paytrace\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;

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

        $this->_registerComponents();
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'commerce-paytrace/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }

    // Private Methods
    // =========================================================================
    private function _registerComponents()
    {
        $this->registerComponents([

        ]);
    }
}
