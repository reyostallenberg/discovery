<?php

namespace PsrDiscovery\Collections;

use PsrDiscovery\Entities\CandidateEntity;

final class CandidatesCollection
{
    /**
     * @param array<string,CandidateEntity> $candidates
     */
    public static function create(
        array $candidates = [],
    ): self {
        return new self($candidates);
    }

    /**
     * @param array<string,CandidateEntity> $candidates
     */
    public function __construct(
        private array $candidates = [],
    ) {
        foreach($this->candidates as $candidate) {
            if (! $candidate instanceof CandidateEntity) {
                throw new \InvalidArgumentException('CandidatesCollection::__construct only accepts an array of valid CandidateEntities.');
            }
        }
    }

    /**
     * @return array<string,CandidateEntity>
     */
    public function all(): array
    {
        return $this->candidates;
    }

    public function add(
        CandidateEntity $candidate,
    ): ?object {
        return $this->candidates[$candidate->getPackage()] = $candidate;
    }

    public function get(
        string $package,
    ): ?CandidateEntity {
        return $this->candidates[$package] instanceof CandidateEntity ? $this->candidates[$package] : null;
    }

    public function remove(
        string $package,
    ): bool {
        $candidate = $this->candidates[$package] ?? null;

        if (null === $candidate) {
            return false;
        }

        unset($this->candidates[$package]);
        return true;
    }

    public function has(
        string $package,
    ): bool {
        return isset($this->candidates[$package]);
    }

    public function prefer(
        CandidateEntity $candidate,
    ): void {
        $candidates = $this->candidates;

        unset($candidates[$candidate->getPackage()]);

        $candidates = array_reverse($candidates, true);
        $candidates[$candidate->getPackage()] = $candidate;
        $candidates = array_reverse($candidates, true);

        $this->candidates = $candidates;
    }
}
