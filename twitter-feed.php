<?php

/* This uses the twitter API key info to pull and output a twitter feed */
$consumerkey = '[enter key here]';
$consumersecret = '[enter secret here]';
$twitterID = 'twitter-user'; // no @ symbol

// Set the counts
$tweetsPulled = '25'; // You can pull back multiple tweets, meaning you could search through tweet information, hashtags etc
$tweetsOutput = '2'; // You can output less tweets than you've pulled back.

// error check for empty vars
if (empty($consumerkey) || empty($consumersecret) || empty($twitterID)){
    echo "Could not get Twitter credentials";
    return false;
}

// Gets $token, required for authenticating
$bearer_token = $consumerkey . ":" . $consumersecret;
$encoded = base64_encode($bearer_token);

$auth_url = "https://api.twitter.com/oauth2/token";
$headers = array(
    "POST /oauth2/token HTTP/1.1",
    "Host: api.twitter.com",
    "User-Agent: my Twitter App v.1",
    "Authorization: Basic ".$encoded."",
    "Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
);

// Make request for bearer token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$auth_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$result = curl_exec($ch);
curl_close($ch);

// Tidy the result to just the access_token
$data = json_decode($result,true);
$token = $data['access_token'];

$request_url = "/1.1/statuses/user_timeline.json?screen_name=".$twitterID."&include_rts=false&count=".$tweetsPulled;
$request_url_full = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitterID."&include_rts=false&count=".$tweetsPulled;

// Build headers for authenticating
$oauth = array(
    $request_url,
    "Host: api.twitter.com",
    "User-Agent: FDM App",
    "Authorization: Bearer ".$token."",
    "Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
);

// Request the tweets
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$request_url_full);
curl_setopt($ch, CURLOPT_HTTPHEADER, $oauth);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$tweets = curl_exec($ch);
curl_close($ch);
$data = json_decode($tweets, true);


// Output the tweets nicely
$counter = 0;
foreach ($data as &$tweet) {
    $counter++;
    $text = $tweet['text'];
    if ((strpos($text,'http') !== false)) {
        $text = preg_replace('!(http|https)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', "<a target='_blank' href=\"\\0\">\\0</a>", $text);

    }
    echo '<div class="tweet-item">';
        echo '<p class="tweet-msg">'.$text.'</p>';
    echo '</div>';

    if ($counter == $tweetsOutput){ // stops when the tweetsOutput value is met
        break;
    }
}

?>