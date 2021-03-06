<?php

declare(strict_types=1);

namespace LaraStrict\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class RemoteUrlRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (is_string($value) === false) {
            return false;
        }

        $parsed = parse_url($value);

        if (is_array($parsed) === false) {
            return false;
        }

        if (in_array($parsed['scheme'] ?? '', ['http', 'https'], true) === false) {
            return false;
        }

        $options = FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE;
        $host = $parsed['host'] ?? '';

        // TODO support IPV6
        if (preg_match('#\d+\.\d+\.\d+\.\d+#', $host) !== 0) {
            $notReservedIp = filter_var($host, FILTER_VALIDATE_IP, $options);

            return $notReservedIp !== false;
        }

        // Must contain top level domain
        return preg_match('#^[\w\d\-.]{1,63}\.[a-z]{2,6}$#', $host) !== 0;
    }

    public function message(): string
    {
        return 'Given :attribute is not a valid url (public IP or domain on http/s protocol)';
    }
}
