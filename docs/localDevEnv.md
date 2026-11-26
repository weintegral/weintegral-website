# Local Development Environment

## Development Tools

### Log Viewer

The Log Viewer is a tool that allows you to view the logs of the different services that are running in the development
environment. It is accessible at [log-viewer](http://localhost:8080/log-viewer).

### Debug App Viewer (Telescope)

Telescope provides insight into the requests coming into your application, exceptions, log entries, database queries,
queued jobs, mail, notifications, cache operations, scheduled tasks, variable dumps, and more. It is accessible at
[telescope](http://localhost:8080/telescope).

## Runtime Versions

The development environment pins every image to an exact tag. These are the versions it provides, taken from
`docker/Dockerfile`, `docker/SchedulerDockerfile`, `docker/SQLDockerfile` and `docker-compose.yml`.

| Tool                    | Version        | Image tag                                                                  |
| ----------------------- | -------------- | -------------------------------------------------------------------------- |
| PHP                     | 8.6.0          | `php:8.6.0-apache-trixie` (web server), `php:8.6.0-cli-trixie` (scheduler) |
| Node                    | 26.13.1        | `node:26.13.1-trixie`                                                      |
| MySQL                   | 9.7.4.1        | `mysql:9.7.4.1`                                                            |
| Composer                | 2.11.3         | `composer:2.11.3`                                                          |
| PHP extension installer | 2.13.4         | `mlocati/php-extension-installer:2.13.4`                                   |
| Mailpit                 | v1.34.0        | `axllent/mailpit:v1.34.0`                                                  |
| Selenium                | 156.0.8078.108 | `selenium/standalone-chromium:156.0.8078.108`                              |
