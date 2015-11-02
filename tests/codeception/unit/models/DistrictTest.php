<?php

use app\models\District;

class DistrictTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
	public function testDistrictsArray(){
			$compareArray = array(
			'2' => 'scholen',
			'3' => 'kerken',
			'4' => 'centrum',
			'5' => 'bushaltes',
			'6' => 'componistenbuurt',
			'7' => 'vinex');

		$district = new District();
		$this->assertEquals($district->getDistrictsArray(), $compareArray);
	}

    // tests create new group
    public function testCreateNewDistrict()    {
		$district = new District();

        $district->name = null;
        $this->assertFalse($district->validate(['name']));

		$district->name = 'The Hood';
        $this->assertTrue($district->validate(['name']));  

        $district->score = null;
        $this->assertFalse($district->validate(['score']));

        $district->score = 'toolooooongnaaaaaaameeee';
        $this->assertFalse($district->validate(['score']));

        $district->score = 2.2;
        $this->assertFalse($district->validate(['score']));

        $district->score = '0,0';
        $this->assertFalse($district->validate(['score']));

		$district->score = 3;
        $this->assertTrue($district->validate(['score']));  

		$district->save();

		$this->assertEquals(3, $district->score);
		$this->tester->seeInDatabase('district', array('name' => 'The Hood',
													   'score' => 3));

    }

    // tests update group
    public function testUpdateDistrict()
    {
		$id = 5;
		$district = District::findOne($id);
		$district->name = 'haltes';
		$district->score = 4;
		$district->save();

		$this->assertEquals(4, $district->score);
		$this->tester->seeInDatabase('district', array('name' => 'haltes',
													'score' => 4));
    }

    // tests delete group
    public function testDeleteDistrict()
    {
		$id = 7;
		$district = District::findOne($id);
		$district->delete();
		$this->tester->dontSeeInDatabase('district', array('name' => 'vinex',
													'score' => 82));
    }
}