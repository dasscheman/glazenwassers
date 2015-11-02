<?php


class StreetTest extends \Codeception\TestCase\Test
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
	public function testStreetsArray(){
			$compareArray = array(
			'2' => 'basisschool',
			'3' => 'middelbareschool',
			'4' => 'martinuskerk',
			'5' => 'franciscuskerk',
			'6' => 'plein',
			'7' => 'markt',
			'8' => 'bushalte a',
			'9' => 'bushalte b',
			'10' => 'bushalte c',
			'11' => 'bushalte d',
			'12' => 'bachlaan',
			'13' => 'ravelstraat');

		$street = new Streets();
		$this->assertEquals($street->getStreetsArray(), $compareArray);
	}

	public static function testStreetsArrayNoKey(){
			$compareArray = array(
				'basisschool',
				'middelbareschool',
				'martinuskerk',
				'franciscuskerk',
				'plein',
				'markt',
				'bushalte a',
				'bushalte b',
				'bushalte c',
				'bushalte d',
				'bachlaan',
				'ravelstraat');

		$streets = new Streets();
		$this->assertEquals($streets->getStreetsArray(), $compareArray);
	}

//    public function testDistrictID($street_id){


//    public function testStreetScore($street_id){


//    public function testStreetsInDistrict($district){

//	public function getDataArrayForGraph(){

	// tests create new group
    public function testCreateNewStreet()    {
		$street = new Street();

        $street->name = null;
        $this->assertFalse($street->validate(['name']));

		$street->name = 'The Hood';
        $this->assertTrue($street->validate(['name']));  

        $street->score = null;
        $this->assertFalse($street->validate(['score']));

        $street->score = 'toolooooongnaaaaaaameeee';
        $this->assertFalse($street->validate(['score']));

        $street->score = 2.2;
        $this->assertFalse($street->validate(['score']));

        $street->score = '0,0';
        $this->assertFalse($street->validate(['score']));

		$street->score = 3;
        $this->assertTrue($street->validate(['score']));  

		$street->save();

		$this->assertEquals(3, $street->score);
		$this->tester->seeInDatabase('street', array('name' => 'The Hood',
													   'score' => 3));

    }

    // tests update group
    public function testUpdateStreet()
    {
		$id = 5;
		$street = Street::findOne($id);
		$street->name = 'haltes';
		$street->score = 4;
		$street->save();

		$this->assertEquals(4, $street->score);
		$this->tester->seeInDatabase('street', array('name' => 'haltes',
													'score' => 4));
    }

    // tests delete group
    public function testDeleteStreet()
    {
		$id = 7;
		$street = Street::findOne($id);
		$street->delete();
		$this->tester->dontSeeInDatabase('street', array('name' => 'vinex',
													'score' => 82));
    }

}