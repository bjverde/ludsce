# LUDS

![visão geral](digital-signage.png)

LUDS ( PHP Digital Signage ), um simples Digital Signage com Player Software via navegador: 

Essa é versão da comunidade, um software livre

Veja esta documentação em outros idiomas:
- :us: [English version](../README.md)
- :brazil: [versão em português disponível](README_pt-BR.md). Esta é a documentação principal. Isso se traduz em outros idiomas
- :es: [versão em espanhol disponível](README_es.md), traduzido pelo Google

outros nomes conhecidos
* midía indoor
* midía tv
* tv corporativa
* painéis digitais
* murais digitais 

Veja mais informações sobre: 
* Como funcioa um Digital Signage - https://www.voxeldigital.com.br/blog/como-funciona-publicacao-digital-signage/
* O que é um CMS - https://www.hostinger.com.br/tutoriais/o-que-e-cms

![visão geral](exemplo01.jpg)

# Requisitos
* PHP 7.4 ou superior
* HTML 5
* CSS 3
* JavaScript
* BootStrap 3.4
* Jquery 3.6
* Adianti Template 7.4.X

# O que tem em cada pasta
* Document - tem apenas imagens e texto auxiliar
* system - é o sistema propriamente dito. Com duas partes:  A externa que web player e a interna administrativa que será acessa na URL `/admin`

# Montanto o Ambiente

1. Clona o projeto localmente ou servidor.
1. Baixar o [Adianti Template 7.4.1 ou superior](https://www.adianti.com.br/framework-download) e copiar o conteúdo do template na pasta `ludsce\system\admin`. *As pastas podem ser mescaladas. Porém NÃO SUBSTITUIR qualquer arquivo*
1. [Instalar o FormDin5 sobre o Adianti Template 7.4.0 ou superior, conforme orientação](https://github.com/bjverde/formDin5#instala%C3%A7%C3%A3o)
1. Vericar com o git, se algum arquivo foi alterado. *Descarta qualquer alteração ou arquivos novos*
1. Ter um servidor PHP 7.4.x ou superior, instalado e configurado com PDO SqLite
1. Realizar o deploy do sitema para o servidor PHP. 
1. Pronto, bastar acessar o sistema


# Concorrentes 

* Hikvision Europe - https://www.youtube.com/channel/UCRY0VuF6yFucrTqMfZk6Bng
