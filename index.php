<?php
$apikey = 'cqkqdys7rzvkwawfzn762wkn';

// make sure to url encode an query parameters
$q = urlencode('red');

// construct the query with our apikey and the query we want to make
$endpoint = 'http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=' . $apikey . '&q=' . $q;
//'&g='. $g. '&b='. $b. '&y='. $y;
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
?>

<ul>

<?php
$i = 0;
$len = count($movies);

foreach ($movies as $movie) {

    if ($i == 0) {
        ?>

            <div style="border:1px solid black; margin:10px 10px 10px 0; padding:10px; width:350px; background:red;">
                <img src="<?php echo $movie->posters->profile; ?>" />
                <a href="' . $movie->links->alternate . '" style="color:white; margin-left:10px;  position:absolute; font-size:25px; font-style:strong;" >
        <?php echo $movie->title; ?> 
                </a>
                <br>
                <br>
                <p style="color:white; margin-left:62px; position:absolute;" >
                    Year: <?php echo $movie->year; ?>
                    <br>
                    Run Time: <?php echo $movie->runtime; ?> min
                    <br>
                    Rating: <?php echo $movie->mpaa_rating; ?>
                </p>
                <h3 style="color:white;">Description:</h3>
                <p style="text-align:justify; color:white;">
        <?php echo $movie->synopsis; ?>
                </p>
            </div>
            <br>

    <?php } else { ?>

            <li><a href="<?php echo $movie->links->alternate; ?> ">
            <?php echo $movie->title; ?> ( <?php echo $movie->year; ?>) 
                    -
                    <?php echo $movie->runtime; ?> min.</a></li>
                <?php
                }

                $i++;
            }
            ?>

</ul>