# CacheBundle
Cache bundle for symfony

Add routes to your routing file:
```
# app/config/routes.yaml
    cache_bundle:
        resource: '@ElectiveCacheBundle/Resources/config/routes.yaml'

```

Add service to your service file:
```
# app/config/services.yaml
    imports:
        - { resource: '@ElectiveCacheBundle/Resources/config/services.yaml' }
```

Add cache subscriptions to your env file, example:
```
# app/.env
    CACHE_SUBSCRIPTIONS=-acl-api-organisation-updated-candidates-api,-acl-api-user-updated-candidates-api
```
