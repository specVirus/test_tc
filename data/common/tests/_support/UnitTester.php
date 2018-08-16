<?php
namespace common\tests;
use Codeception\Lib\Connector\Yii2\FixturesStore;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;
    
    protected $store;
    
   /**
    * Define custom actions here
    */

    public function haveFixtures($fixtures)
    {
        $this->store = new FixturesStore($fixtures);
        $this->store->loadFixtures();
        $this->loadedFixtures[] = $this->store;
    }

    public function unloadFixtures()
    {
        if (!empty($this->store)) {
            $this->store->unloadFixtures();
        }
    }
}
