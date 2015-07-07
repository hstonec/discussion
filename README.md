# discussion

1. Check if apache has write to upload file to these to these two folder:
    
    ./upload
    ./photo

2. If not, do these steps:
      a. Execute `ps aux | grep httpd`.
      b. Change the owner of folders to be become whatever the owner you found in step a.
      c. Chmod folders now to be writable by the owner, if needed.