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

# Montanto o Ambiente

1. PHP 7.3.x ou superior, instalado e configurado com PDO SqLite
1. Clona o projeto
1. Baixar o [Adianti Template 7.4.1 ou superior](https://www.adianti.com.br/framework-download) e copiar o conteúdo da pasta para `system\admin`. *As pastas podem ser mescaladas. Porém NÃO SUBSTITUIR qualquer arquivo*
1. [Instalar o FormDin5 sobre o Adianti Template 7.4.0 ou superior](https://github.com/bjverde/formDin5#instala%C3%A7%C3%A3o)
1. Abrir VsCode e ir para controle de versão. *Descarta qualquer alteração ou arquivos novos*
1. Pronto !!


# Similar Software 
| Name             | Site                                                     | GitHub                                    | Description                          |
|------------------|----------------------------------------------------------|-------------------------------------------|--------------------------------------|
| Xibo             | https://xibo.org.uk/                                     |                                           | Most Famous software Digital Display |
| Hikvision Europe | https://www.youtube.com/channel/UCRY0VuF6yFucrTqMfZk6Bng |                                           |                                      |
| smil control     | https://smil-control.com/                                | https://github.com/sagiadinos             |                                      |
| CampusVision     | https://johnsonlm.com/CampusVision/                      | https://github.com/JohnsonLM/CampusVision |                                      |
