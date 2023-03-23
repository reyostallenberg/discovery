<?php

declare(strict_types=1);

namespace PsrDiscovery\Implementations;

use PsrDiscovery\Collections\CandidatesCollection;
use PsrDiscovery\Contracts\Implementations\ImplementationContract;
use PsrDiscovery\Entities\CandidateEntity;

abstract class Implementation implements ImplementationContract
{
    /**
     * Return the candidates collection.
     */
    abstract public static function candidates(): CandidatesCollection;

    public static function add(CandidateEntity $candidate): void
    {
        static::candidates()->add($candidate);
    }

    public static function prefer(CandidateEntity $candidate): void
    {
        static::candidates()->prefer($candidate);
    }

    public static function set(CandidatesCollection $candidates): void
    {
        static::candidates()->set($candidates);
    }
}
