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
* PHP 7.4 ou superior
* HTML 5
* CSS 3
* JavaScript
* BootStrap 3.4
* Jquery 3.6
* Adianti Template 7.4.X

# What's in each folder
* Document - has only images and auxiliary text
* system - is the system itself. With two parts: The external one that web player and the internal administrative that will be accessed in the URL `/admin`

# Assembling web application

1. Clone the project locally or server.
1. Download [Adianti Template 7.4.1 or higher](https://www.adianti.com.br/framework-download) and copy the template content in the `ludsce\system\admin` folder. *Folders can be merged. But DO NOT REPLACE any file*
1. [Install FormDin5 over Adianti Template 7.4.0 or higher, as directed](https://github.com/bjverde/formDin5#instala%C3%A7%C3%A3o)
1. Check with git if any files have changed. *Discard any changes or new files*
1. Have a PHP 7.4.x server or higher, installed and configured with PDO SqLite
1. Deploy the system to the PHP server.
1. Ready, just access the system


# Similar Software 
| Name             | Site                                                     | GitHub                                    | Description                          |
|------------------|----------------------------------------------------------|-------------------------------------------|--------------------------------------|
| Xibo             | https://xibo.org.uk/                                     |                                           | Most Famous software Digital Display |
| Hikvision Europe | https://www.youtube.com/channel/UCRY0VuF6yFucrTqMfZk6Bng |                                           |                                      |
| smil control     | https://smil-control.com/                                | https://github.com/sagiadinos             |                                      |
| CampusVision     | https://johnsonlm.com/CampusVision/                      | https://github.com/JohnsonLM/CampusVision |                                      |
