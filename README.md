# Getting started
## Installation
Fork this repository and change the configuration to your needs.

This project runs on [Docker Compose] and therefore requires that you have [Docker Desktop] installed.
Once you have done that, run the following command in your terminal:

```
$ docker-compose up --build
```

## Traefik
Thanks to [Traefik] you can now access the project with this URL:
http://my-landing-page.localhost

> *Note: The URL can be changed by editing the `PROJECT_DOMAIN` environment variable.*

[Docker Compose]: https://docs.docker.com/compose/
[Docker Desktop]: https://www.docker.com/products/docker-desktop
[Traefik]: https://doc.traefik.io/traefik/
