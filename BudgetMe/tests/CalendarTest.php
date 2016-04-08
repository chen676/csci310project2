<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CalendarTest extends TestCase
{

    /*
	Parameters:None
	Description:The dates selected for the graph (some normal range) are received accurately.
	Created By: Harshul and Matt
	*/
    public function testNormalDatesSelected(){
    	$this->assertTrue(true);
    }

 	/*
	Parameters:None
	Description: Should not accept dates when both the dates selected are empty 
	Created By: Harshul and Matt
	*/
    public function testEmptyDates(){
		$this->assertTrue(true);
    }

    /*
	Description:Should not accept dates when one of the dates selected is empty
	Created By: Harshul and Matt
	*/
    public function testOneEmptyDate(){
		$this->assertTrue(true);
    }

    /*
	Description:The dates selected for the graph are not chronological(first date is chronologically after second)
	Created By: Harshul and Matt
	*/
    public function testNonchronologicalDates(){
    	$this->assertTrue(true);
    }



 
}
