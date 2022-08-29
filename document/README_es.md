# LUDS

![visão geral](digital-signage.png)

LUDS ( PHP Digital Signage ), una señalización digital simple con software de reproductor a través del navegador:

Esta es la versión comunitaria, software gratuito.

Consulte esta documentación en otros idiomas:
- :us: [versión en inglés](../README.md)
- :brazil: [Versión en portugués disponible](README_pt-BR.md). Esta es la documentación principal. Esto se traduce a los otros idiomas.
- :es: [Versión en español disponible](README_es.md),traducido por Google

otros nombres conocidos
* medios interiores
* medios de televisión
* televisión corporativa
* paneles digitales
* murales digitales

Ver más información sobre:
* Cómo funciona una Señalización Digital - https://www.voxeldigital.com.br/blog/como-funciona-publicacao-digital-signage/
* ¿Qué es un CMS? - https://www.hostinger.com.br/tutorials/o-que-e-cms

![visão geral](exemplo01.jpg)

# Requisitos
* PHP 7.4 o superior
* HTML 5
* CSS 3
* JavaScript
* BootStrap 3.4
* Jquery 3.6
* Adianti Template 7.4.X

# Que hay en cada carpeta
* Documento: solo tiene imágenes y texto auxiliar
* sistema - es el sistema mismo. Con dos partes: La externa que reproductor web y la administrativa interna a la que se accederá en la URL `/admin`

# Montaje de aplicación web

1. Clone el proyecto localmente o en el servidor.
1. Descargue [Plantilla Adianti 7.4.1 o superior](https://www.adianti.com.br/framework-download) y copie el contenido de la plantilla en la carpeta `ludsce\system\admin`. * Las carpetas se pueden combinar. Pero NO REEMPLAZAR ningún archivo*
1. [Instalar FormDin5 sobre Adianti Template 7.4.0 o superior, como se indica](https://github.com/bjverde/formDin5#instala%C3%A7%C3%A3o)
1. Verifique con git si algún archivo ha cambiado. *Descarta cualquier cambio o archivo nuevo*
1. Tener un servidor PHP 7.4.x o superior, instalado y configurado con PDO SqLite
1. Implemente el sistema en el servidor PHP.
1. Listo, solo accede al sistema


# Concorrentes 

* Hikvision Europe - https://www.youtube.com/channel/UCRY0VuF6yFucrTqMfZk6Bng
