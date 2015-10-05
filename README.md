# Highly-Customisable-Tweets
Outputs tweets in very basic styling for easy CSS and layout changes.

## How it works

This script uses PHP, cURL and Oauth to gather tweets using a 'consumer secret' and 'consumer key' taken from the Twitter developers panel.

You'll be able to get your twitter feed up and running in a matter of minutes. Just pop the code into the page, or alternatively save the `twitter-feed.php` file elsewhere and call it in with a PHP `require_once`.

## Setting the arguments

There are a number of arguments you can set for the feed:

**consumerkey** - the key from Twitter Developers
**consumersecret** - the secret from Twitter Developers
**twitterID** - the ID/handle of the twitter account without an '@' symbol. E.g franhaselden
**tweetsPulled** - this integer dictates how much data is retrieved. You can pull back many tweets, and then filter and sort through them if you like
**tweetsOutput** - this value can be different to 'tweetsPulled', it's just the amount of tweets output onto the page. It cannot be more than 'tweetsPulled'

## Styling and Layout

The last section of the script handles the output. At present, each tweet is wrapped in `.tweet-item` class and the message text is output in a `p.tweet-msg` element. Edit the HTML as much as you like!
