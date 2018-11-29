# Baltic Robo API

[![Build Status](
 https://travis-ci.org/balticrobo/website-api.svg?branch=master)](
  https://travis-ci.org/balticrobo/website-api)

API to serve [Baltic Robo](https://balticrobo.eu) event. It provides bunch of
 functionalities to show front page (eg. our sponsors and partners), opt-in for
 newsletter, allow to register constructors and robots, sign up for event, judge
 all battles etc.

This API is main entrypoint for all related applications built by our team.
 Also, after contact, we are able to prepare extended functions which allows to
 create fans apps.

## Development
Just one word: **Docker**!

```bash
# run docker containers
docker-compose up -d
# and seed database (do it once)
docker-compose exec php bin/console doctrine:fixtures:load
```

## Testing, Linting and Sniffing
**Docker** again!

```bash
docker-compose -f docker-compose.test.yaml up --exit-code-from test_php
```

Travis checks code too!

## Production
It's not time to talk about creating production build. We will talk about it
 later.
