# Room Reservation System for FMI WEB course
### Quick links
- [Backlog](https://github.com/gdgenchev/FMI-Room-Reservation-WEB-Project/projects/1)
- [Create new issue](https://github.com/gdgenchev/FMI-Room-Reservation-WEB-Project/issues/new)

### How to setup the project
 - Download and install Git Bash from [here](https://git-scm.com/downloads)
 - Download and install the latest version of xampp from [here](https://www.apachefriends.org/download.html)
 - Go to C:\xampp\htdocs, right click, Git Bash Here and execute:
     - git clone https://github.com/gdgenchev/FMI-Room-Reservation-WEB-Project.git
 - Run C:\xampp\xampp-control.exe and start Apache and MySQL
 - Open Command Prompt and execute:
     - cd C:\xampp\mysql\bin
     - mysql -u root <C:\xampp\htdocs\sql\project.sql (make sure you use the mysql executable from xampp, if you have another mysql installed)
 - Navigate to some html page(e.g http://localhost/FMI-Room-Reservation-WEB-Project/project/register.html)
 - To update your local project - git pull --rebase origin master
