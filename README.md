# Login_1DV610
A login system written in PHP.

## Use cases
Use cases and requirements: https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md

## Additional use cases
In addition to the use cases referenced above, some additional use cases have been made.
### List of usernames
#### Main scenario
1. Starts when a user wants to see a list of usernames
2. System authenticated the user (UC1, UC3)
3. User is presented with a list of usernames
#### Alternative scenario
* 2a. System could not authenticate user
1. System presents an empty list of usernames
2. Step 2 in UC1

## Set up
* clone https://github.com/sios13/1DV610-L2.git
* install sqlite3 https://www.sqlite.org/
* create a SQLite database called 'db.db' with command: sqlite3 db.db
* create a table of users using the following command:
CREATE TABLE users(name, password, cookie_password, cookie_timer);
* put the 'db.db' file one level outside the root project folder
* visit index.php and it should work!
