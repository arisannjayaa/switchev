<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ChecklistEquipmentRequest;
use App\Http\Requests\ConversionRequest;
use App\Http\Requests\FormDocumentRequest;
use App\Http\Requests\FormResponsibleWorkshopRequest;
use App\Http\Requests\RejectConversionRequest;
use App\Services\Conversion\ConversionService;
use Illuminate\Http\Request;

class ConversionController extends Controller
{
    protected $conversionService;
    public function __construct(ConversionService $conversionService)
    {
        $this->conversionService = $conversionService;
    }

    /**
     * halaman daftar data konversi
     * @return mixed
     */
    public function index()
    {
        return $this->conversionService->checkStatusUser();
    }

    /**
     * form halaman konversi
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|void
     */
    public function form($id = null)
    {
        if (auth()->user()->isGuest() && auth()->user()->isVerified()) {
            $data['conversion'] = @$this->conversionService->find($id)->getResult();
            return view('apps.conversion.form', $data);
        }
    }

    /**
     * form halaman konversi
     * @param $step
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|void
     */
    public function formResponsibleWorkshop($step, $id = null)
    {

        if (auth()->user()->isGuest() && auth()->user()->isVerified()) {
//            if ($this->conversionService->isFormCompleted(auth()->user()->id)) {
//                return redirect()->route('conversion.index');
//            }

            $totalSteps = 4;
            $data['conversion'] = $this->conversionService->find(Helper::decrypt($id))->getResult();

            if ($step < 1 || $step > $totalSteps) {
                return redirect()->route('conversion.form', ['step' => 1]);
            }

            if ($step > 1 && !$this->conversionService->hasCompletedPreviousStep(auth()->user()->id, $step - 1, Helper::decrypt($id))) {
                return redirect()->route('conversion.form', ['step' => $step - 1]);
            }



            $data['titleStep'] = Helper::check_step_form_title($step);
            $data['form'] = $step;

            return view('apps.conversion.form', $data);
        }
    }

    /**
     * tambah atau update data konversi
     * @param FormResponsibleWorkshopRequest $request
     * @return never
     */
    public function upsertFormResponsibleWorkshop(FormResponsibleWorkshopRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['type',
            'workshop',
            'address',
            'person_responsible',
            'whatapp_responsible',
            'id','step','step_1_completed']);
        return $this->conversionService->upsertFormResponsibleWorkshop($data)->toJson();
    }

    /**
     *
     * @param FormDocumentRequest $request
     * @return never
     */
    public function upsertFormDocument(FormDocumentRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only([
            'application_letter',
            'old_application_letter',
            'technician_competency',
            'old_technician_competency',
            'equipment',
            'old_equipment',
            'sop',
            'old_sop',
            'wiring_diagram',
            'old_wiring_diagram',
            'step_2_completed',
            'step',
            'id']);
        return $this->conversionService->upsertFormDocumentRequest($data)->toJson();
    }

    /**
     * @param ConversionRequest $request
     * @return never
     */
    public function upsert(ConversionRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['type',
            'workshop',
            'address',
            'person_responsible',
            'whatapp_responsible',
            'application_letter',
            'technician_competency',
            'equipment',
            'sop',
            'wiring_diagram',
            'status',
            'id']);
        return $this->conversionService->upsert($data)->toJson();
    }

    /**
     * @return mixed
     */
    public function table()
    {
        return $this->conversionService->table();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|never
     */
    public function show($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['conversion'] = $this->conversionService->findOrFail(Helper::decrypt($id))->getResult();
        $data['attachments'][] = $data['conversion']->application_letter;
        $data['attachments'][] = $data['conversion']->equipment;
        $data['attachments'][] = $data['conversion']->technician_competency;
        $data['attachments'][] = $data['conversion']->sop;
        $data['attachments'][] = $data['conversion']->wiring_diagram;

        return view('apps.conversion.detail', $data);
    }

    /**
     * @param Request $request
     * @return never
     */
    public function approve(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        return $this->conversionService->approve($request->id)->toJson();
    }

    /**
     * @param RejectConversionRequest $request
     * @return never
     */
    public function reject(RejectConversionRequest $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['message', 'id', 'nohtml']);
        return $this->conversionService->reject($data)->toJson();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|never
     */
    public function verification($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['conversion'] = $this->conversionService->find(Helper::decrypt($id))->getResult();

        if (@$data['conversion']->status == 'is_being_uploaded') {
            return redirect()->route('conversion.index');
        }

        $data['attachments'][] = $data['conversion']->application_letter;
        $data['attachments'][] = $data['conversion']->equipment;
        $data['attachments'][] = $data['conversion']->technician_competency;
        $data['attachments'][] = $data['conversion']->sop;
        $data['attachments'][] = $data['conversion']->wiring_diagram;
        return view('apps.conversion.verification', $data);
    }

    /**
     * @param Request $request
     * @return never
     */
    public function sendMail(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['message','id','title']);
        return $this->conversionService->sendEmail($data)->toJson();
    }

    /**
     * @param ChecklistEquipmentRequest $request
     * @return mixed
     */
    public function checklist(ChecklistEquipmentRequest $request)
    {
        $data = $request->only(['status','id']);
        return $this->conversionService->checklist($data)->toJson();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function process_detail($id)
    {
        $data['conversion'] = $this->conversionService->find(Helper::decrypt($id))->getResult();

        return view('apps.conversion.guest-proses', $data);
    }
}
