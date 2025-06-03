<?php

namespace App\Services\TemplateCertificate;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\TemplateCertificate\TemplateCertificateRepository;

class TemplateCertificateServiceImplement extends ServiceApi implements TemplateCertificateService{

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

    public function __construct(TemplateCertificateRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
