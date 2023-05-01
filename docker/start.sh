#!/usr/bin/env bash

set -e

env=${APP_ENV:-production}
role=${CONTAINER_ROLE:-app}

echo "The environment is $env"

if [ "$role" = "app" ]; then
    echo "Container role \"$role\""
else
    echo "Container role \"$role\""
fi

exec apache2-foreground
