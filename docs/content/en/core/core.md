---
title: Actions
category: Core
---

Set of actions that are often used to speed things up.

# PipeActions

Ideal for executing set of checks that conditionally wants to stop execution by returning a value.

```php
public function __invoke(
    AddEmailRequest $request,
    AddEmailQuery $addEmailQuery,
    RateLimiter $rateLimiter,
    PipeAction $pipeAction
): MessageResponse|RateLimitedResponse {
    return $pipeAction->execute(
        [
            fn() => $this->checkLimiter(
                throttleKey: 'add-email:' . $request->ip(),
                rateLimiter: $rateLimiter,
                maxAttempts: 2
            ),
            fn() => $this->checkLimiter(
                throttleKey: 'add-email:' . $request->getEmail(),
                rateLimiter: $rateLimiter,
                maxAttempts: 1
            ),
            function () use ($addEmailQuery, $request): void {
                $addEmailQuery->execute($request->getEmail());
            }
        ],
        fn() => new MessageResponse(HttpMessage::Ok)
    );
}
```
