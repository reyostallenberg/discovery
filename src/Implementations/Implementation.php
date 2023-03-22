<?php

declare(strict_types=1);

namespace PsrDiscovery\Implementations;

use PsrDiscovery\Collections\CandidatesCollection;
use PsrDiscovery\Contracts\Implementations\ImplementationContract;
use PsrDiscovery\Discover;
use PsrDiscovery\Entities\CandidateEntity;

abstract class Implementation implements ImplementationContract
{
    abstract public static function candidates(): CandidatesCollection;

    final public static function add(CandidateEntity $candidate): void
    {
        static::$candidates ??= static::candidates();
        static::$candidates->add($candidate);
        static::$singleton = null;
        static::$using     = null;
    }

    final public static function discover(): ?object
    {
        if (null !== static::$using) {
            return static::$using;
        }

        return Discover::httpClient();
    }

    final public static function prefer(CandidateEntity $candidate): void
    {
        static::$candidates ??= static::candidates();
        static::$candidates->prefer($candidate);
        static::$singleton = null;
        static::$using     = null;
    }

    final public static function set(CandidatesCollection $candidates): void
    {
        static::$candidates = $candidates;
        static::$singleton  = null;
        static::$using      = null;
    }

    final public static function singleton(): ?object
    {
        if (null !== static::$using) {
            return static::$using;
        }

        return static::$singleton ??= static::discover();
    }

    final public static function use(?object $instance): void
    {
        static::$singleton = $instance;
        static::$using     = $instance;
    }
    protected static ?CandidatesCollection $candidates = null;
    protected static ?object $singleton                = null;
    protected static ?object $using                    = null;
}