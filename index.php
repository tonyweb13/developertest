<?php

$apikey = 'cqkqdys7rzvkwawfzn762wkn';

$q = urlencode('red'); // make sure to url encode an query parameters
// construct the query with our apikey and the query we want to make
$endpoint = 'http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=' . $apikey . '&q=' . $q;


// setup curl to make a call to the endpoint
$session = curl_init($endpoint);

// indicates that we want the response back
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// exec curl and get the data back
$data = curl_exec($session);

// remember to close the curl session once we are finished retrieveing the data
curl_close($session);

// decode the json data to make it easier to parse the php
$search_results = json_decode($data);

if ($search_results === NULL)
    die('Error parsing json');

// play with the data!
$movies = $search_results->movies;

echo '<ul>';

$i = 0;
$len = count($movies);

foreach ($movies as $movie) {

    if ($i == 0) {
        echo '<div style="border:1px solid black; margin:10px 10px 10px 0; padding:10px; width:350px; background:red;">';
        echo '<img src="' . $movie->posters->profile . '" />';
        echo '<a href="' . $movie->links->alternate . '" style="color:white; margin-left:10px; position:absolute; font-size:25px; font-style:strong;" >' . $movie->title . '</a>';
        echo '<br>';
        echo '<br>';
        echo '<p style="color:white; margin-left:62px; position:absolute;" >';
        echo 'Year: ' . $movie->year;
        echo '<br>';
        echo 'Run Time: ' . $movie->runtime . ' min.';
        echo '<br>';
        echo 'Rating: ' . $movie->mpaa_rating;
        echo '</p>';

        echo '<h3 style="color:white;">Description:</h3>';
        echo '<p style="text-align:justify; color:white;">' . $movie->synopsis . '</p>';
        echo '</div>';
        echo '<br>';
    } else {

        echo '<li><a href="' . $movie->links->alternate . '">' . $movie->title . " (" . $movie->year . ") - " . $movie->runtime . " min.</a></li>";
    }

    $i++;
}

echo '</ul>';
?>