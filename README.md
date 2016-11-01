# clash_of_clans_player_profile

I spent some time this weekend making use of the new API features released a couple weeks ago (I didn't realize until this weekend they were already out!) and made a mock-up of the in-game player profiles based on the new API features.

[Here's an example](http://i.imgur.com/2jM3zs2.png)

Let me know what you guys think. 

Note, if you pull it, you need to set the api key and the player tag for it to work. It should otherwise be fully functional.

On my clan's site, I have the player tag load from the $_GET variable (with a default set, in case there is no $_GET). This way, I can load the player profile into a <dialog> box from a table of our users, generated from the clan/{clanTag}/members API.
