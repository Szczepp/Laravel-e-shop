<?php
namespace Magently\Module\Model;
use Magently\Module\View\CandidateName;

class CandidateProvider {
    public function show_candidate
    (   )
    {
        // $this->
    }
    public $candidateName;

    public function __construct(\Framework\DatabaseConnection $c, CandidateName $candidateName) {
        $this->db_connection = $c;
        $this->candidateName = $candidateName;
    }

    public function getCandidates($candidatesId)
    {
        $candidatesCount = count($candidatesId);
        if ($candidatesCount > 0)
        {
            foreach ($candidatesId as $key => $candidate_id) {
                $data[] = $this->db_connection->select()->from('candidates')->where('candidate_id = ' . $candidate_id)->fetch();
            }
            return $data;
        } else {

        }
        $info = 'true';
    }

    public function candidate_info($candidateId) {
        if ($candidateId) {
            $candidateInfo = $this->db_connection->select()->from('candidates')->where('candidate_id = ' . $candidateId)->fetch();
        }
        return $candidateInfo;
    }

    /**
     * @param $candidate
     * @return boolean
     */
    public function is_candidate_active ($candidateId)
    {
        if ($candidateId)
        {
            $candidateInfo = $this->db_connection->select()->from('candidates')->where('candidate_id = ' . $candidateId)->fetch();
        }
        if ((int) $candidateInfo['is_active'] == '1') {
            return true;
        } else {
            return false;
        }
    }

}
