# CLIO

El proyecto CLIO se centra en el control de los sitios patrimoniales asi como en los objetos y obras en el país. Lleva un registo de la ubicación exacta de cada elemento teniendo en cuenta que el usuario del sistema añada en los registros la latitud y longitud de dicho sitio u objeto.

## Tecnologías Utilizadas

**Tecnologías:** Symfony, Twig, Bootstrap, JQuery.


## Como Utilizarlo

Clonar el proyecto

```bash
  git clone https://github.com/jorgeale90/CLIO
```

Acceder al directorio de dicho proyecto

```bash
  cd CLIO
```

Instalar las dependencias

```bash
  composer install
```

Crear la Base de Datos

```bash
  php bin/console doctrine:database:create
```

Actualizar las tablas de la Base de Datos

```bash
  php bin/console doctrine:schema:update --force
```

Ejecutar el servidor

```bash
  symfony server:start
```

## Screenshot

![](https://github.com/jorgeale90/CLIO/blob/main/public/screenshot/1.png)
![](https://github.com/jorgeale90/CLIO/blob/main/public/screenshot/2.png)
![](https://github.com/jorgeale90/CLIO/blob/main/public/screenshot/3.png)
![](https://github.com/jorgeale90/CLIO/blob/main/public/screenshot/4.png)
![](https://github.com/jorgeale90/CLIO/blob/main/public/screenshot/5.png)
![](https://github.com/jorgeale90/CLIO/blob/main/public/screenshot/6.png)
![](https://github.com/jorgeale90/CLIO/blob/main/public/screenshot/7.png)
