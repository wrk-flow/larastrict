# Console

## Schedule

Wraps a Laravel schedule to it own schedule service that will:

- Log all output to `/proc/1/fd/2` if LOG_CHANNEL is set to `stterr` or `docker` environment is set
- Allow scheduling command in queue (differently than Laravel does)
  - Ensure it is unique and prevents overlapping (uses `AbstractUniqueLongJob`)
  - Logs (`Running command`) when command started and how long it took.
  - Logs (`Command finished`) command failure with duration and message.

### Setup

- To register schedule extend `AbstractServiceProvider` and select contract to implement
  - **HasSchedule** (registers schedule on all environments)
  - **HasScheduleOnProduction** (registers schedule only on production environment)
- Use `queueCommand`

### Example

```php
<?php

declare(strict_types=1);

namespace App\Confirmations;

use App\Confirmations\Commands\ExpireConfirmationsCommand;
use Illuminate\Contracts\Container\BindingResolutionException;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Contracts\HasSchedule;

class ConfirmationsServiceProvider extends AbstractServiceProvider implements HasSchedule
{
    public function register(): void
    {
        parent::register();

        $this->commands([
            ExpireConfirmationsCommand::class,
        ]);
    }

    /**
     * @throws BindingResolutionException
     */
    public function schedule(ScheduleServiceContract $schedule): void
    {
        $schedule->queueCommand(ExpireConfirmationsCommand::class);
    }
}

```

### Extending / changing schedule logic

Register your implementation in your `AppServiceProvider`. Ensure that AppServiceProvider is before any service
provider that uses `AbstractServiceProvider` in `config/app.php`

```php
$this->app->alias(MyScheduleServiceService::class, ScheduleServiceContract::class);
```
