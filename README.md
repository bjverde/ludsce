# LUDS

![visão geral](document/digital-signage.png)

LUDS ( PHP Digital Signage ), a simple Digital Signage with Player Software via browser:

This is Community Edition, free software

See this documentation in other languages:
- :us: [English version](README.md)
- :brazil: [Portuguese version available](document/README_pt-BR.md). This is main documentation. This translates to the other languages
- :es: [Spanish version available](document/README_es.md), translated by Google

other known names
* indoor media
* tv media
* corporate tv
* digital panels
* digital murals

See more information about:
* How a Digital Signage works - https://www.voxeldigital.com.br/blog/como-funciona-publicacao-digital-signage/
* What is a CMS - https://www.hostinger.com.br/tutorials/o-que-e-cms

![visão geral](document/exemplo01.jpg)

# Requirements
* PHP 8.0.x or higher
* [Adianti Fork Template 7.6.0.X ou superior](https://github.com/bjverde/adianti-fork-template/)

# What's in each folder
* database - SQL script to create the database see `maindatabase.sql` file. Extra permissions script see `permission-inserts-complemento.sql` file
* document - documentation with images and auxiliary text.
* system - is the system itself. With two parts: The external one, which is the web player, and the internal administrative one, which will be accessed at the URL `/admin`

# Assembling web application

1. Clone the project locally or on the server.
1. Download [Adianti Fork Temaplate 7.6.0.1](https://github.com/bjverde/adianti-fork-template/releases/tag/v7.6.0.1) and copy the template content in the `ludsce\system\admin` folder. *Folders can be merged. But DO NOT REPLACE any*. Note you can use the original [Adianti Fork Temaplate 7.6.0.1](https://github.com/bjverde/adianti-fork-template/releases/tag/v7.6.0.1)
1. [Install FormDin5 over Adianti Fork Template 7.6.01 or higher, as directed](https://github.com/bjverde/formDin5#instala%C3%A7%C3%A3o)
1. Check with git if any files have changed. *Discards any changes or new files*
1. Have a PHP 8.0.x server or higher, installed and configured with PDO SqLite.
1. On the PHP server create the `ludsce` folder
1. Copy the contents of the `system` folder to the `ludsce` created in the previous item.
1. That's it, just access the system
     1. External part that will be shown on TVs, http://SERVIDOR/ludsce/
     1. Administrative part: http://SERVIDOR/ludsce/admin

user | password | profile
------ | ------------------ | --------------------
admin | admin | it is super user can do everything in the system.
user | user | it is ordany user can only post Digital Signage

# Similar Software 
| Name             | Site                                                     | GitHub                                    | Description                          |
|------------------|----------------------------------------------------------|-------------------------------------------|--------------------------------------|
| Xibo             | https://xibo.org.uk/                                     |                                           | Most Famous software Digital Display |
| Hikvision Europe | https://www.youtube.com/channel/UCRY0VuF6yFucrTqMfZk6Bng |                                           |                                      |
| smil control     | https://smil-control.com/                                | https://github.com/sagiadinos             |                                      |
| CampusVision     | https://johnsonlm.com/CampusVision/                      | https://github.com/JohnsonLM/CampusVision |                                      |
