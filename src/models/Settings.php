<?php
/**
 * commerce-paytrace plugin for Craft CMS 3.x
 *
 * Craft Commerce 2 Payment Gateway for PayTrace
 *
 * @link      https://github.com/unionco
 * @copyright Copyright (c) 2019 UNION
 */

namespace unionco\paytrace\models;

use unionco\paytrace\PayTrace;

use Craft;
use craft\base\Model;

/**
 * @author    UNION
 * @package   PayTrace
 * @since     0.0.1
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $someAttribute = 'Some Default';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['someAttribute', 'string'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ];
    }
}
