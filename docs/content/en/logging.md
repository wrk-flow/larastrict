---
title: Logging
---

- Use `$context` array for debugging "values". This can be used for filtering in your log UI.
```php
$this->logger->debug('Discarding typology pairing for a provider', [
    'provider_id' => $event->providerId,
]); 
```
