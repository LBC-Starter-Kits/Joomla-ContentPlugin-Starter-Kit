# Plugin de contenido base

Este plugin permite sustituir el contenido entre tags {plugin_base} y {/plugin_base} por otro texto como scripts, iframes, etc... El contenido entre los tags debe ser un objeto JSON de la siguiente forma {"index":"indice"}. 

## Prerrequisitos
* NodeJs
* composer

## Preparación para desarrollo
* En primer lugar crearemos un nuevo repositorio en nuestra máquina local y obtenemos el código desde el este repositorio.
~~~
git init foo
cd foo
git pull https://github.com/LBC-Starter-Kits/Joomla-ContentPlugin-Starter-Kit.git
~~~

* Instalamos las dependencias del archivo package.json
~~~
npm install
~~~

* Instalamos las dependencias del archivo composer.json
~~~
composer install
~~~

* Por último ejecutamos el script build
~~~
npm run build
~~~

## Getting Started


### Instalación

En el directorio dist_zip de este proyecto se genera el archivo j3contentplugin_base.zip que puede instalarse desde el gestor de extensiones de Joomla.

### Configuracón

Una vez instalado el plugin debe ser activado en el gestor de extensiones.

## Authors

* **Luis BC** - *Initial work* - [Luinux81](https://github.com/LuinuX81)
