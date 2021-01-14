# Imagefy - Self Hosted Image Service

Imagefy is a easy to setup self-hosted image service

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
- PHP 7.4
- MYSQL
- composer
- Nodejs
- Apache Web Server
```

### Installing

A step by step series of examples that tell you how to get a development env running

Clone & Setup Imagefy

```
Clone this repository
cd into project directory
run composer install
run npm run production
```

Setup Database & .env file

```
rename .env.example to .env
edit .env file (database, Digital Ocean spaces)
save file
run php artisan migrate
```

## Built With

* [Laravel](https://laravel.com) - The web framework used
* [Digital Ocean](https://www.digitalocean.com/) - Digital Ocean

## Contributing

Please read [CONTRIBUTING.md](./CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/OpenDevCommunity/imagefy/tags). 


## License

This project is licensed under the MIT License - see the [LICENSE.md](./LICENSE) file for details
