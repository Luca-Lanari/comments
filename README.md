# Project Title

This project is made with Symfony 3: it saves and displays the comments 

## Introduction

This project has been made to learn and practice Symfony and all its tools.


### Prerequisites

Install node.js (https://nodejs.org)


### Installing

Install Bower into the project directory

```
$ npm install -g bower
```

## Run

First of all create the database:

```
$ php bin/console doctrine:database:create
```
Then create the entity:

```
$ php bin/console doctrine:generate:entity
```

Run the develop server:

```
$ php bin/console server:run
```



