<?php

use app\models\Group;

class GroupTest extends \Codeception\TestCase\Test
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


	public function testGroupScore()
    {
		$id = 3;
		$group = Group::findOne($id);
		$this->assertEquals(333, $group->getGroupScore());

		$id = 4;
		$group = Group::findOne($id);
		$this->assertEquals(308, $group->getGroupScore());

		$id = 5;
		$group = Group::findOne($id);
		$this->assertEquals(311, $group->getGroupScore());
    }

	public function testGroupsArray(){
		$compareArray = array(
			'3' => 'team a',
			'4' => 'team b',
			'5' => 'team c',
			'6' => 'team d');

		$group = new Group();
		$this->assertEquals($group->getGroupsArray(), $compareArray);
	}

    // tests create new group
    public function testCreateNewGroup()
    {
		$group = new Group();

        $group->name = null;
        $this->assertFalse($group->validate(['name']));

		$group->name = 'GROEP1';
        $this->assertTrue($group->validate(['name']));  

        $group->members = null;
        $this->assertFalse($group->validate(['members']));

		$group->members = 'DEELNEMER1 DEELNEMER2';
        $this->assertTrue($group->validate(['members']));  

        $group->start_score = null;
        $this->assertFalse($group->validate(['start_score']));

        $group->start_score = 'toolooooongnaaaaaaameeee';
        $this->assertFalse($group->validate(['start_score']));

        $group->start_score = 2.2;
        $this->assertFalse($group->validate(['start_score']));

        $group->start_score = '0,0';
        $this->assertFalse($group->validate(['start_score']));

		$group->start_score = 3;
        $this->assertTrue($group->validate(['start_score']));  

		$group->save();

		$this->assertEquals(3, $group->start_score);
		$this->tester->seeInDatabase('group', array('name' => 'GROEP1',
													'members' => 'DEELNEMER1 DEELNEMER2',
													'start_score' => 3));

    }

    // tests update group
    public function testUpdateGroup()
    {
		$id = 3;
		$group = Group::findOne($id);
		$group->name = 'GROEP2';
		$group->members = 'DEELNEMERA DEELNEMERB';
		$group->start_score = 4;
		$group->save();

		$this->assertEquals(4, $group->start_score);
		$this->tester->seeInDatabase('group', array('name' => 'GROEP2',
													'members' => 'DEELNEMERA DEELNEMERB',
													'start_score' => 4));

    }

    // tests delete group
    public function testDeleteGroup()
    {
		$id = 6;
		$group = Group::findOne($id);
		$group->delete();

		$this->tester->dontSeeInDatabase('group', array('name' => 'team d',
													'members' => 'defg',
													'start_score' => 300));

    }
}