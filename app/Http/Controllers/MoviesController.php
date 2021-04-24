<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


class MoviesController extends BaseController
{
	private $movieJson = "/app/moviedata.json";
    public function listMovies()
    {
    	$filePath =  storage_path().$this->movieJson;
    	$contents = file_get_contents($filePath);
    	$movieData =  json_decode($contents, true);
    	usort($movieData, function($a, $b)
	    {
	    	if ($a==$b) return 0;
	  			return ($a>$b)?-1:1;
	    });
	   
		foreach ($movieData as $key => $sub_array) {
			if($key > 3)
				break;
		    $topMovies[] = $sub_array;
		}

	   return (new Response($topMovies, "200"))->header('Content-Type', "json");
    	
    }

    public function searchMovies(Request $request)
    {
    	$movieName =  $request->input('movieName');
    	$filePath =  storage_path().$this->movieJson;
    	$contents = file_get_contents($filePath);
    	$movieData =  json_decode($contents, true);
    	$searchKey = array_search($movieName, array_column($movieData, 'title'));
    	if($searchKey != "")
    	{
    		$searchData[] = $movieData[$searchKey];
    	}
    	return (new Response($searchData, "200"))->header('Content-Type', "json");
    }
}
