# discussion

Project: Discussion
Group Member: Shicong Huang, Jheng-Sian You, Xuanyu Liu


Installation Instructions

1. Change the default Database information to yours in libraries/databaseClassMySQLi.php

2. In the install folder, there are two sql scripts:
     
     discussion.sql has the required  table structure and data
     dummy.sql has some dummy data

3. After you execute the discussion.sql, there will be a default Root user which username
   is rootroot and password is 123456.
   
   All the users in the dummy.sql has the same password 123456.

3. Please Check if apache has write to upload file to these two folder:
    
    ./upload
    ./photo

4. If not, do these steps:
      a. Execute `ps aux | grep httpd`.
      b. Change the owner of folders to be become whatever the owner you found in step a.
      c. Chmod folders now to be writable by the owner, if needed.