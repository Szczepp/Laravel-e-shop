<?php
namespace Magently\Module\Model;

use Framework\Database\Orm;


class CandidateProvider {
    /**
     * @param Orm $orm
     */
    public function __construct(
        public Orm $orm
    )
    {
        //
    }

    /**
     * @param $candidateId
     * @return array|string
     */
    public function getCandidate($candidateId): array | string
    {
        return $this->orm->select()->from('candidates')->where('candidate_id = ' . $candidateId)->fetch() ?? 'Candidate not found';
    }

    /**
     * @return array|string
     */
    public function getCandidates(): array | string
    {
         return $this->orm->select()->from('candidates')->fetch() ?? 'The candidates table is empty';
    }

    /**
     * @param array $candidatesId
     * @return array|string
     */
    public function getCandidatesById(array $candidatesId): array | string
    {
        $data = [];
        foreach ($candidatesId as $candidateId) {
            $data[] = $this->getCandidate($candidateId);
        }

        return $data;
    }

    /**
     * @param $candidate
     * @return boolean
     */
    public function isActive($candidateId): bool
    {
            return $this->orm->select('is_active')->from('candidates')->where('candidate_id = ' . $candidateId)->fetch();
    }
}
