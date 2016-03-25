Slack Bot
=========
About
-----
This is a starting point for a slack bot. The goal is to have a bot that's easily extendable, based mostly on composer packages and easy to work with.

Getting started
---------------
1. Create a bot integration in your channel and make sure you have a token that has access to your account. (@TODO create page to help with this).
2. Copy the config-example.php file to config.php and edit it to suit your needs.
3. Copy the slackbot.service file to your systemd directory so you can use systemd to manage the php process.
4. Run `service start slackbot` to start the bot and make it connect to slack using your token.

Creating plugins
----------------
1. Create controller and/or service classes.
2. Reference the custom classes in the composer.json file to get the loaded.
3. Add services to services.php and controllers to routing.php
4. If needed edit config.php.
