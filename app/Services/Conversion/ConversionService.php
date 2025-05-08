<?php

namespace App\Services\Conversion;

use LaravelEasyRepository\BaseService;

interface ConversionService extends BaseService{

    public function checkStatusUser();

    public function checkConversion();

    public function table();

    public function approve($id);

    public function reject($data);

    public function upsert($data);

    public function sendEmail($data);

    public function findByUserId($user_id, $id);

    public function upsertFormResponsibleWorkshop($data);

    public function upsertFormDocumentRequest($data);

    public function hasCompletedPreviousStep($user, $step, $conversionId);

    public function isFormCompleted($userId);

    public function checklist($data);
}
