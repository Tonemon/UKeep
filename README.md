# UKeep Project
<p align="center">Online planner and advanced note taking service. UTasks, UNotes and a lot of new features.<br>
</p>

## About This Project
UKeep is an advanced online planner and note taking service. It can be installed locally to manage your notes and tasks or on a remote server to share the installation with multiple people. This project is a merge of two other projects, [UTasks](https://github.com/Tonemon/UTasks) and [UNotes](https://github.com/Tonemon/UNotes), with a new dashboard template and a lot of new features. The pupose of this project is to learn how to implement new features while 'reviving' two of my older projects and compiling them into one big project. Programming languages like HTML, CSS (mostly [Bootstrap](https://getbootstrap.com/)), a little bit of JavaScript (mostly Bootstrap too), PHP and MySQL have been used and to host this project locally during development I have been using [AMPPS](https://www.ampps.com/), which features a PHPMyAdmin installation and easy local domain configuration.

## Features
This project inherited a lot of features from the old UTasks and UNotes projects, but a lot of new features are added regularly. Some of these features are:

* A new fully customizable SMART Dashboard, [SB Admin 2](https://startbootstrap.com/themes/sb-admin-2/) theme used, which displays important information about your tasks, notes and labels.
* An items page with an advanced search feature, which displays all of your items depending on your search criteria so you can easily find, edit and delete the particular note or task you have been searching for. You can also sort your items by status (active/archived), notes or tasks only, duedate set this week, passed deadlines, todo in the future and a lot more.
* Taking notes/tasks can be done in seconds and saving them with different labels helps to keep them seperated and organized. Bookmarked items appear on your SMART Dashboard for easy access.
* Your note/task editing page is different depending on the item you edit. You can turn a note to a task with one click to make it an active TODO item and to include it in your SMART Dashboard analysis.
* Users can use the built-in support panel to ask questions, which can then be answered directly by admin users in their administration panel. Answered questions appear in the built-in support panel so users don't have to go to their mailbox to read the answer.
* There are 3 different user accounts types (normal, premium and admin users) with different permissions (more information about the permissions will come soon).
* There are 2 environments (`/dashboard/` and `/admin/`). The dashboard can be used by every user, including admins, while the `/admin/` panel can only be used by admins to answer questions, manage users, send server messages, manage invitation codes and more.
* There is a detailed guide available for all users, which contains information about all of UKeep's features.
* Every user has a public profile from which they can be added as a contact. Using the profile customization panel in the setting you can specify which information is displayed on your profile and which information is private. You can also change account information including your profile picture.
* The Dashboard global theme, redirect to specified page after login and sidebar items can be selected in the customization panel in the settings.
* (Coming Soon) Share a collection of notes and tasks with your organization by creating a team and keeping all of the items in one place.
* (Coming Soon) Share your notes with your friends by adding them to your contacts. After connecting a new sharing button will popup, which lets you share a note or task with your friends/coworkers.
* (Coming Soon) Invite your friends to UKeep using your special code to gain points. These can later be exchanged for rewards like premium months.

## Important Details
If you are planning on running this project on your own PC or Remote server, you should keep these things in mind.
1. This project has no real homepage (yet). To login, register or change a forgotten password you will need to use the `/login.php` page.
2. There are two environments: `/dashboard/` and `/admin/`. Normal, premium and admin users can take notes and tasks in the `/dashboard/` environment and admin users can go to the `/admin/` environment to access the administration panel. This panel is unaccessible for normal/premium users.
3. This project contains two databases (called `UKeepMAIN` and `UKeepDAT`). The `UKeepMAIN` database contains important global data, like users and their preferences, questions and answers, contacts and more. The `UKeepDAT` database contains the notes/tasks/labels of each user. Both of these databases will need to connected to one database user, which has all permissions to these databases (more about this process in the installation process).
4. Feel free to add/remove any user except the main admin account with userid 1 in the `UKeepMAIN` database. Removing this user will make the whole system unusable as it is the only account that can add new administrator users. If you don't want to make use of this account, you should change the password and disable the account using a new administrator type account.
5. For security reasons it is recommended to change the (password hashing) salt after installation by changing the `$salt` variable in the `/dashboard/essentials.php` file.

## Installation
If you want to install this project locally or on a remote server, please follow the following steps:
1. Download the latest version of this project by using the 'Clone or download' option on the homepage of this repository or download a [specific release](https://github.com/Tonemon/UKeep/releases).
2. Make sure your system has Apache, PHP and MySQL up and running (the AMPPS installation manual can be found [here](http://www.ampps.com/wiki/Main_Page).
3. Extract the main folder called `website` to your localhost folder and rename it to `ukeep.me`.
4. Add the following entry to your `.hosts` file, which will let you use a custom url instead of `localhost/ukeep.me`.
    <pre>127.0.0.1 ukeep.me</pre>
5. Go to your PHPMyAdmin configuration (the default URL is http://localhost/phpmyadmin/) and create 2 new databases, called `UKeepDAT` and `UKeepMAIN`. Then create a new database user, called `UKeepUser` with the password `UKeepPassword`. You can change this default information in the `/dashboard/essentials.php` file.
6. Import both of the `UKeep____.sql` files in their coresponding database.
7. Make sure the `UKeepUser` database user has all permissions to both databases. To do this, go to `Users` > `Edit Privileges` > `Database` > `Add privileges on the following database(s)`.
<br>
The installation process is complete. Go to the login page http://ukeep.me/login and sign in using the one of the following combinations: 

* `admin@ukeep.me` & `adminpassword` (email / password) OR 
* `admin` & `adminpassword` (username / password)</pre>

## Credits
Check the [Wiki credits page](https://github.com/Tonemon/UKeep/wiki/Credits) for all credits.
