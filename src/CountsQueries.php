<?php

namespace Tithe;

use Illuminate\Support\Facades\DB;

trait CountsQueries
{
    protected bool $hasDispatchedQueryCounter = false;

    protected bool $isCountingQueries = false;

    protected int $queryCount = 0;

    public function whileCountingQueries(callable $callback)
    {
        $this->startCountingQueries();

        $result = $callback();

        $this->stopCountingQueries();

        return $result;
    }

    public function startCountingQueries()
    {
        if (! $this->hasDispatchedQueryCounter) {
            $this->dispatchQueryCounter();
        }

        $this->isCountingQueries = true;
        $this->hasDispatchedQueryCounter = true;
    }

    public function stopCountingQueries(): int
    {
        $this->isCountingQueries = false;

        return $this->getQueryCount();
    }

    public function getQueryCount(): int
    {
        return $this->queryCount;
    }

    public function assertDatabaseQueriesCount(int $expectedCount)
    {
        return $this->assertEquals($expectedCount, $this->getQueryCount());
    }

    private function dispatchQueryCounter()
    {
        DB::listen(function () {
            if ($this->isCountingQueries) {
                $this->queryCount++;
            }
        });
    }
}
