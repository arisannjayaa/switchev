<?php

namespace App\Services\CertificateTestLetter;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\CertificateTestLetter\CertificateTestLetterRepository;

class CertificateTestLetterServiceImplement extends ServiceApi implements CertificateTestLetterService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected $title = "";
     /**
     * uncomment this to override the default message
     * protected $create_message = "";
     * protected $update_message = "";
     * protected $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(CertificateTestLetterRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    /**
     * @param $test_letter_id
     * @param $type
     * @return mixed
     */
    public function generate_sk($test_letter_id, $type)
    {
        // TODO: Implement generate_sk() method.
    }

    /**
     * @param $test_letter_id
     * @param $type
     * @return mixed
     */
    public function generate_certificate_srut($test_letter_id, $type)
    {
        // TODO: Implement generate_certificate_srut() method.
    }

    /**
     * @param $test_letter_id
     * @param $type
     * @return mixed
     */
    public function generate_certificate_sut($test_letter_id, $type)
    {
        // TODO: Implement generate_certificate_sut() method.
    }

    /**
     * @return mixed
     */
    public function send_draft()
    {
        // TODO: Implement send_draft() method.
    }
}
