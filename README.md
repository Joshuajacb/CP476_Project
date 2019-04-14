# CP476_Project

To run this project locally you must have a xampp or mamp installation on your machine.
Once you have one of these project servers installed, extract the project folder into the htdocs folder.

I have included a sql file that you should use to install the database required for the project. It also includes some default values in the tables to get you started.

The install includes 4 users and 4 channels, they're listed as follows:

## Username / Password:

  Josh / cp476!
  
  Megan / 123123
  
  Nero / 123123
  
  Leroy / 123123
  
## Channels: 

  Joshs Channel
  
  Megans Channel
  
  Leroy Channel
  
  Nero Channel
  
  
  
## Additional instructions:  
  
You can create your own username and channels once you install everything and open the app. 

Joining channels currently does not exist, to add users to a channel you create you have to do this manually through the DB.

To do this, get your user ID from the users table and the channel_id from the channel_details table. Add these to the channel_users table using the following SQL command

#### INSERT INTO `channel_users`(`channel_id`, `user_id`) VALUES ([your channel id],[your user id])
