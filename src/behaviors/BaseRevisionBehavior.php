<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace craft\behaviors;

use craft\base\ElementInterface;
use craft\elements\User;
use yii\base\Behavior;

/**
 * BaseRevisionBehavior is the base implementation of draft & revision behaviors.
 *
 * @property ElementInterface $owner
 * @property User|null $creator
 * @property-read $sourceId
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.5.0
 */
abstract class BaseRevisionBehavior extends Behavior
{
    /**
     * @var int|null The creator’s ID
     */
    public $creatorId;

    /**
     * @var User|null|false The creator
     */
    private $_creator;

    /**
     * Returns the draft’s creator.
     *
     * @return User|null
     */
    public function getCreator()
    {
        if ($this->_creator === null) {
            if (!$this->creatorId) {
                return null;
            }

            $this->_creator = User::find()
                    ->id($this->creatorId)
                    ->anyStatus()
                    ->one()
                ?? false;
        }

        return $this->_creator ?: null;
    }

    /**
     * Sets the draft's creator.
     *
     * @param User|null $creator
     * @since 3.5.0
     */
    public function setCreator(User $creator = null)
    {
        $this->_creator = $creator ?? false;
    }

    /**
     * Returns the draft/revision’s source element.
     *
     * @return ElementInterface|null
     * @deprecated in 3.2.9. Use [[ElementInterface::getCanonical()]] instead.
     */
    public function getSource()
    {
        if ($this->owner->getIsCanonical()) {
            return null;
        }
        return $this->owner->getCanonical();
    }

    /**
     * Returns the draft/revision's source element ID.
     *
     * @return int
     * @since 3.7.0
     * @deprecated in 3.7.0. Use [[ElementInterface::getCanonicalId()]] instead.
     */
    public function getSourceId(): int
    {
        return $this->owner->getCanonicalId();
    }
}
