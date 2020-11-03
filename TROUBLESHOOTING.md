#In case of issues
1) In case doesn't show images:
This issue occur because php use the gd library to create images, you can:
*[Locate php.ini]

First locate the "php.ini", open with a text editor and uncomment the line:
```bash
;;extension=gd2
```
save the file, and restart the server.

*[restart the server]

In unix-like OS, open a terminal and type:

```bash
sudo systemctl restart apache2.service
```
*[In case there is missing gd library]

In unix-like OS, open a terminal and type:

```bash
sudo apt-get install php>version>-gd
```
*[In case is unable to create a file]

In unix-like OS, open a terminal andgive permssion to the master folder:

```bash
sudo chmod -R 777 {master_folder}
```

Other problems send mail to:

```bash
luisro5@hotmail.com
luisro5azaar@gmail.com
```
