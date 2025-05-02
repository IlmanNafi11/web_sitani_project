<?php

namespace App\Trait;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;

trait LoggingError
{
    protected function LogSqlException(QueryException $e, array $data = [], string $message = null): void
    {
        Log::error($message ?? 'Database error di ' . __METHOD__ , [
            'data' => $data,
            'exception' => $e,
        ]);
    }

    protected function LogGeneralException(Throwable $e, array $data = [], string $message = null): void
    {
        Log::error($message ?? 'Terjadi kesalahan tak terduga di ' . __METHOD__ , [
            'data' => $data,
            'exception' => $e,
        ]);
    }

    protected function LogNotFoundException(Throwable $e, array $data = [], string $message = null): void
    {
        Log::info($message ?? 'Data tidak ditemukan', [
            'data' => $data,
            'exception' => $e,
            'source' => __METHOD__,
        ]);
    }
}
