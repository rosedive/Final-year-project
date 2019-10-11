<?php

namespace App\Http\Controllers\Web;

use Cache;
use App\Http\Controllers\Controller;
use App\Clearance;
use App\User;
use App\Notification;
use App\Department;
use App\Option;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use App\Support\Enum\RequestStatus;
use App\Support\Enum\ReasonsStatus;

use App\Repositories\Clearance\ClearanceRepository;
use App\Http\Requests\Clearance\CreateClearanceRequest;
use App\Http\Requests\Clearance\UpdateClearanceRequest;
use Illuminate\Http\Request;
use PDF;

class ClearancesController extends Controller
{
    private $clearances;

    public function __construct(ClearanceRepository $clearances)
    {
        $this->middleware('auth');
        $this->middleware('permission:clearance.manage');
        $this->clearances = $clearances;
    }

    public function index()
    {
        $clearances = $this->clearances->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status')
        );

        $statuses = ['' => 'All'] + RequestStatus::lists();
        $reasons = ReasonsStatus::lists();

        return view('clearance.index', compact('clearances', 'statuses', 'reasons'));
    }

    public function create()
    {
        $edit = false;
        $reasons = ReasonsStatus::lists();

        return view('clearance.add-edit', compact('edit', 'reasons'));
    }

    public function store(CreateClearanceRequest $request)
    {
        $data = $request->all() + ['status' => RequestStatus::REQUESTED];

        $this->clearances->create($data);

        return redirect()->route('student.clearance')
            ->withSuccess('Clearance created');
    }

    public function edit(Clearance $clearance)
    {
        $edit = true;
        $reasons = ReasonsStatus::lists();

        return view('clearance.add-edit', compact('edit', 'clearance', 'reasons'));
    }

    public function update(Clearance $clearance, UpdateClearanceRequest $request)
    {
        $this->clearances->update($clearance->id, $request->all());

        return redirect()->route('student.clearance')
            ->withSuccess('Clearance updated');
    }

    public function delete(Clearance $clearance)
    {
        // if (! $clearance->removable) {
        //     throw new NotFoundHttpException;
        // }

        $this->clearances->delete($clearance->id);

        Cache::flush();

        return redirect()->route('student.clearance')
            ->withSuccess('Clearance deleted');
    }

    public function tracking(Request $req)
    {
        $reasons = ReasonsStatus::lists();
        $trackId = $req->query('track-id');
        $tracking = false;
        $data = array();

        if( !empty($trackId) ) {
            $tracking = true;
            $clearance = Clearance::where('id', $trackId)->first();
            $notfiyCode = '';

            if(! empty($clearance) && $clearance->regno == auth()->user()->username)
            {
                if($clearance->status == 'Requested') {
                    $notfiyCode = 'warning';
                } elseif($clearance->status == 'Processing') {
                    $notfiyCode = 'info';
                    
                } elseif($clearance->status == 'Approved') {
                    $notfiyCode = 'success';
                } else {
                    $notfiyCode = 'danger';
                }

                $notifications = Notification::
                                    where('request_id', $clearance->id)
                                    ->groupBy('date', 'created_by')
                                    ->orderBy('id', 'ASC')
                                    ->get();
                foreach ($notifications as $notification) {
                    $res['date'] = $notification->created_at;
                    $res['message'] = $this->getTrackMessage($notification->created_by, $notification->request_id, $notification->date);
                    array_push($data, $res);
                }
            }
        }

        return view('clearance.tracking', compact('clearance', 'data', 'tracking', 'reasons', 'notfiyCode'));
    }

    public function getTrackMessage($id, $reqId, $date)
    {
        return Notification::where('created_by', $id)
                ->where('request_id', $reqId)
                ->where('date', $date)
                ->orderBy('time', 'ASC')->get();
    }

    public function generatePDFfile(Clearance $clearance)
    {
        if($clearance =='' || $clearance->status != RequestStatus::APPROVED)
        {
           abort(404); 
        }

        $user = User::where('username', $clearance->regno)->first();
        if($user =='') {
            abort(404);
        }

        $department = Department::where('id', $user->department_id)->first();
        if($department =='') {
            abort(404);
        }

        $option = Option::where('id', $user->option_id)->first();
        if($option =='') {
            abort(404);
        }

        $notification = Notification::where('created_by', $clearance->id)->orderBy('id', 'DESC')->first();
        if($notification =='') {
            abort(404);
        }

        $graduation = '';
        $supension = '';
        $issue = '';

        if($clearance->reason == 'graduation') {
            $graduation = 'checked';
        }
        if($clearance->reason == 'suspension') {
            $supension = 'checked';
        }
        if($clearance->reason == 'issue_certificate') {
            $issue = 'checked';
        }

        $data = [
            'regno' => $clearance->regno,
            'names' => $user->last_name .' '. $user->first_name,
            'sponsor' => $user->sponsorship,
            'department' => $department->name,
            'option' => $option->name,
            'program' => $user->program,
            'level' => $clearance->level,
            'phone' => $user->phone,
            'graduation' => $clearance->reason == 'graduation' ? 'Checked' : '',
            'supension' => $clearance->reason == 'suspension' ? 'Checked' : '',
            'issue' => $clearance->reason == 'issue_certificate' ? 'Checked' : '',
            
            'hod_date' => $this->getOfficerName($clearance->id, 'hod_check', 'date'),
            'hod_name' => $this->getOfficerName($clearance->id, 'hod_check', 'name'),
            'hod_remarks' => $clearance->hod_check == 1 ? 'Clear' : 'Not checked',
            
            'drsa_date' => $this->getOfficerName($clearance->id, 'student_affair_check', 'date'),
            'drsa_name' => $this->getOfficerName($clearance->id, 'student_affair_check', 'name'),
            'drsa_remarks' => $clearance->student_affair_check == 1 ? 'Clear' : 'Not checked',
            
            'lib_date' => $this->getOfficerName($clearance->id, 'library_check', 'date'),
            'lib_name' => $this->getOfficerName($clearance->id, 'library_check', 'name'),
            'lib_remarks' => $clearance->library_check == 1 ? 'Clear' : 'Not checked',
            
            'reg_date' => $this->getOfficerName($clearance->id, 'adm_reg_check', 'date'),
            'reg_name' => $this->getOfficerName($clearance->id, 'adm_reg_check', 'name'),
            'reg_remarks' => $clearance->adm_reg_check == 1 ? 'Clear' : 'Not checked',
            
            'finance_date' => $this->getOfficerName($clearance->id, 'finance_check', 'date'),
            'finance_name' => $this->getOfficerName($clearance->id, 'finance_check', 'name'),
            'finance_remarks' => $clearance->finance_check == 1 ? 'Clear' : 'Not checked',
        ];

        $pdf = PDF::loadView('clearance.doc', $data);

        return $pdf->download('clearance.pdf');
    }

    public function getOfficerName($id, $check, $type)
    {
        $notification = Notification::where('request_id', $id)->where('checking', $check)->first();
        $officer = User::where('id', $notification->created_by)->first();
        if($type == 'date')
            return $notification->created_at;
        else
            return $officer->last_name .' '. $officer->first_name;
    }
}