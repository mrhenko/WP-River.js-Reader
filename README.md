# WP River.js Reader #

This WordPress plugin reads a [River.js](http://riverjs.org) file and displays a [River of News](http://scripting.com/2014/06/02/whatIsARiverOfNewsAggregator.html) in a widget.

It's intentionally very light on styling, instead it let's the C in CSS do the job and inherits the look from the current theme.

WP River.js is __not a river of news aggregator__. You need a separate aggregator to generate the river.js file that WP River.js reads and outputs in a WordPress plugin. (I can recommend [River4](http://river4.smallpict.com) or [River5](https://github.com/scripting/river5) for your aggregator needs.)

## River of News? River.js? ##

A [River of News](http://scripting.com/2014/06/02/whatIsARiverOfNewsAggregator.html) is a reversed-chronological list of items that has a title (optional), a content body, a link back to the source and some meta data. It's generally generated from one or more RSS feeds.

River.js is a JSON representation of a River of News [as defined by Dave Winer](http://riverjs.org).

Basically you could say that your Twitter timeline is a river of news, at least as long as it's not algorithmically filtered by Twitter.