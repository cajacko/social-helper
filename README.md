# Social Helper
Social Helper is a tool that automates your social media profiles. Currently social helper can automatically retweet popular and recent items based off a set of Twitter search queries.

To get started make sure you have Docker installed, download the repo and set up a Twitter App so you can use Twitter's API.

Copy the .env-sample file as .env and change the values as necessary:
- CONSUMER_KEY - Is your Twitter Apps key
- CONSUMER_SECRET - Is your Twitter Apps secret
- CALLBACK_DOMAIN - Is the domain you will run the web interface of Social Helper
- SESSION_SECRET - Should be changed to a random string
- API_DOMAIN - Leave as the same for now
- APP_AUTH - Should be a random string
- MYSQL_ROOT_PASSWORD - Should be a the MySQL root users password
- MYSQL_DATABASE - Is the database we will be connecting to
- MYSQL_USER - The MySQL user we will be connecting as
- MYSQL_PASSWORD - The password we will use to access the database

All the MySQL env variables can be random strings, as the database will get setup in a Docker container.

With this ready you should be able to run:

```
./run
```

This builds all the docker images and runs them, only use this for the production version.

If you are developing social helper then make sure you have nodejs installed and run:
```
npm install
npm setup
```
To install all the dependecies and run the docker containers. To develop the front end run:
```
cd web
npm install
npm webpack
```
This will use webpack to continually watch and compile all the React JS code that runs the front end of the website.

If you want to debug the API server you can run:
Check cron logs
```
npm run docker-api-bash
cat /var/log/syslog
```
To check out the system logs.
