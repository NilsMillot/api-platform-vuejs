# MAIN COMMANDS FOR DEV:

- Onboarding: `docker compose build --pull --no-cache` then `docker compose up` (add -d for daemon and if you want to see logs then `docker compose logs -f`)

- Start client: `cd client/ && npm install && npm run dev`

## Commands for Backend

### Generate JWT Certificates

```
docker compose exec php sh -c '
  set -e
  apk add openssl
  php bin/console lexik:jwt:generate-keypair
  setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
  setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
'
```

### Load Fixtures

```
docker compose exec php app/console doctrine:fixtures:load
```

### Migration

```
docker compose exec php bin/console make:migration
docker compose exec php bin/console doctrine:migrations:migrate
```

# ADDITIONNAL PROJECT INFOS:

- Our vuejs app is in client/
- vuejs client was created with [create-client api-platform](https://api-platform.com/docs/create-client/vuejs/)
- A main util for us can be to create CRUD instantly in vuejs check the theird command intitulated [generate all the code you need for a given resource](https://api-platform.com/docs/create-client/vuejs/)

# OFFICIAL DOC:

API Platform is a next-generation web framework designed to easily create API-first projects without compromising extensibility
and flexibility:

- Design your own data model as plain old PHP classes or [**import an existing ontology**](https://api-platform.com/docs/schema-generator).
- **Expose in minutes a hypermedia REST or a GraphQL API** with pagination, data validation, access control, relation embedding,
  filters and error handling...
- Benefit from Content Negotiation: [GraphQL](https://api-platform.com/docs/core/graphql/), [JSON-LD](https://json-ld.org), [Hydra](https://hydra-cg.com),
  [HAL](https://github.com/mikekelly/hal_specification/blob/master/hal_specification.md), [JSON:API](https://jsonapi.org/), [YAML](https://yaml.org/), [JSON](https://www.json.org/), [XML](https://www.w3.org/XML/) and [CSV](https://www.ietf.org/rfc/rfc4180.txt) are supported out of the box.
- Enjoy the **beautiful automatically generated API documentation** ([OpenAPI](https://api-platform.com/docs/core/openapi/)).
- Add [**a convenient Material Design administration interface**](https://api-platform.com/docs/admin) built with [React](https://reactjs.org/)
  without writing a line of code.
- **Scaffold fully functional Progressive-Web-Apps and mobile apps** built with [Next.js](https://api-platform.com/docs/client-generator/nextjs/) (React),
  [Nuxt.js](https://api-platform.com/docs/client-generator/nuxtjs/) (Vue.js) or [React Native](https://api-platform.com/docs/client-generator/react-native/)
  thanks to [the client generator](https://api-platform.com/docs/client-generator/) (a Vue.js generator is also available).
- Install a development environment and deploy your project in production using **[Docker](https://api-platform.com/docs/distribution)**
  and [Kubernetes](https://api-platform.com/docs/deployment/kubernetes).
- Easily add **[OAuth](https://oauth.net/) authentication**.
- Create specs and tests with **[a developer friendly API testing tool](https://api-platform.com/docs/distribution/testing/)**.

[![GitHub Actions](https://github.com/api-platform/core/workflows/CI/badge.svg)](https://github.com/api-platform/core/actions?workflow=CI)
[![Codecov](https://codecov.io/gh/api-platform/core/branch/master/graph/badge.svg)](https://codecov.io/gh/api-platform/core/branch/master)

The official project documentation is available **[on the API Platform website](https://api-platform.com)**.

API Platform embraces open web standards and the
[Linked Data](https://www.w3.org/standards/semanticweb/data) movement. Your API will automatically expose structured data.
It means that your API Platform application is usable **out of the box** with technologies of
the semantic web.

It also means that **your SEO will be improved** because **[Google leverages these formats](https://developers.google.com/search/docs/guides/intro-structured-data)**.

Last but not least, the server component of API Platform is built on top of the [Symfony](https://symfony.com) framework,
while client components leverage [React](https://reactjs.org/) ([Vue.js](https://vuejs.org/) flavors are also available).
It means that you can:

- Use **thousands of Symfony bundles and React components** with API Platform.
- Integrate API Platform in **any existing Symfony, React or Vue application**.
- Reuse **all your Symfony and JavaScript skills**, benefit of the incredible amount of documentation available.
- Enjoy the popular [Doctrine ORM](https://www.doctrine-project.org/projects/orm.html) (used by default, but fully optional:
  you can use the data provider you want, including but not limited to MongoDB and Elasticsearch)

## Install

[Read the official "Getting Started" guide](https://api-platform.com/docs/distribution).

## Credits

Created by [Kévin Dunglas](https://dunglas.fr). Commercial support available at [Les-Tilleuls.coop](https://les-tilleuls.coop).
