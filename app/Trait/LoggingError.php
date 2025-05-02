<?php

namespace App\Trait;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;

trait LoggingError
{
    protected function LogSqlException(QueryException $e, array $data = [], string $message = null): void
    {
        Log::error($message ?? 'Terjadi kesalahan pada query', [
            'error' => $e->getMessage(),
            'sql' => $e->getSql(),
            'bindings' => $e->getBindings(),
            'data' => $data,
            'trace' => $e->getTraceAsString(),
        ]);
    }

    protected function LogGeneralException(Throwable $e, array $data = [], string $message = null): void
    {
        Log::error($message ?? 'Terjadi kesalahan tak terduga', [
            'error' => $e->getMessage(),
            'data' => $data,
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
