<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MoviesApiTest extends TestCase
{
    /**
     * Test movies list
     *
     * @return void
     */
    public function testMoviesList()
    {
        $response = $this->call('POST', 'api/list');
        $this->assertEquals(200, $response->status());
        $this->seeJsonStructure(
            [
                [
                    'year',
                    'title'
                ]
            ]    
        );
    }

    /**
     * Test movies search
     *
     * @return void
     */
    public function testMoviesSearch()
    {
        $response = $this->call('POST', 'api/search', ['movieName' => "Elysium"]);
        
        $this->seeJsonContains([
              'year'    => 2013,
              'title'   => 'Elysium',
             ]);
        
    }
}
