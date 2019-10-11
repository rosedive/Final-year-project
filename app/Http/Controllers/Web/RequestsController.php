<?php

namespace App\Http\Controllers\Web;

use Cache;
use App\Http\Controllers\Controller;
use App\Clearance;
use App\Department;
use App\Option;
use App\Result;
use App\User;
use App\Notification;
use App\Hostel;
use App\Library;
use App\Registration;
use App\Finance;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use App\Support\Enum\RequestStatus;
use App\Support\Enum\ReasonsStatus;

use App\Repositories\Request\RequestRepository;
use App\Http\Requests\Clearance\UpdateRequest;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    private $requests;

    protected $step1, $step2, $step3, $step4, $step5;

    public function __construct(RequestRepository $requests)
    {
        $this->middleware('auth');
        $this->middleware('permission:clearance.request.manage');
        $this->requests = $requests;
    }

    public function index()
    {
        $requests = array();
        $data = $this->requests->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status')
        );

        $redirect = '';
        $my_task = '';
        $hod = false;

        switch (auth()->user()->role->name) {
            case 'head_of_department':
                $hod = true;
                $my_task = 'hod_check';
                $redirect = 'results';
                break;

            case 'director_of_student_affairs':
                $my_task = 'student_affair_check';
                $redirect = 'hostel';
                break;

            case 'chief_of_library':
                $my_task = 'library_check';
                $redirect = 'library';
                break;

            case 'admission_officer':
                $my_task = 'adm_reg_check';
                $redirect = 'regsitration';
                break;

            case 'income_controller':
                $my_task = 'finance_check';
                $redirect = 'finance';
                break;
        }

        $statuses = ['' => 'All'] + RequestStatus::lists();
        $reasons = ReasonsStatus::lists();

        foreach ($data as $key => $value) {

            if($hod) {
                $userId = auth()->user()->id;
                $user = User::where('username', $value->regno)->first();
                $departments = Department::where('hod', $userId)->get();
                foreach ($departments as $key => $department) {
                    if($user->department_id == $department->id) {
                        array_push($requests, $value);
                    }
                }
            } else {
                array_push($requests, $value);
            }
        }

        return view('request.index', compact('requests', 'statuses', 'reasons', 'redirect', 'my_task'));
    }

    public function view(Request $req)
    {
        $id = $req->query('request');
        $check = $req->query('check');

        $clearance = Clearance::where('id', $id)->first();
        if ($clearance == '')
            abort(404);

        if ($clearance->status == RequestStatus::REQUESTED ) {
            $u['status'] = RequestStatus::PROSESSING;
            $clearance->update($u);

            $tim = date('H:i:s');
            $endtim = strtotime("-5 minutes", strtotime($tim));
            $fintim = date('H:i:s', $endtim);

            $c['checking'] = '';
            $c['created_by'] = 0;
            $c['date'] = date('Y-m-d');
            $c['time'] = $fintim;
            $c['request_id'] = $id;
            $c['message'] = '* Your application opened';
            Notification::create($c);
        }

        $user = User::where('username', $clearance->regno)->first();
        if ($user == '')
            abort(404);

        $option = Option::where('id', $user->option_id)->first();
        if ($option == '')
            abort(404);

        $department = Department::where('id', $option->department_id)->first();
        if ($department == '')
            abort(404);

        $allowcheck = 'none';
        $res = [];
        $reasons = ReasonsStatus::lists();

        switch (auth()->user()->role->name) {
            case 'head_of_department':
                $allowcheck = 'result';
                $res = $this->CheckResults($id, $user->username, 'hod_check');
                break;

            case 'director_of_student_affairs':
                $allowcheck = 'hostel';
                $res = $this->CheckHostels($id, $user->username, 'hod_check', 'student_affair_check');
                break;

            case 'chief_of_library':
                $allowcheck = 'library';
                $res = $this->CheckLibrary($id, $user->username, 'student_affair_check', 'library_check');
                break;

            case 'admission_officer':
                $allowcheck = 'registration';
                $res = $this->CheckRegistration($id, $user->username, 'library_check', 'adm_reg_check');
                break;

            case 'income_controller':
                $allowcheck = 'finance';
                $res = $this->CheckFinance($id, $user->username, 'adm_reg_check', 'finance_check');
                break;

            default:
                abort(404);
                break;
        }

        return view('request.view', compact('allowcheck', 'clearance', 'reasons', 'user', 'department', 'option', 'res'));
    }

    public function store(UpdateRequest $request)
    {
        $clearance = Clearance::find($request->request_id);

        if ($request->decision == '1') {
            $data['created_by'] = auth()->user()->id;
            $data['date'] = date('Y-m-d');
            $data['time'] = date('H:i');
            $data['request_id'] = $request->request_id;
            $data['message'] = '* <b>'. auth()->user()->role->display_name .'</b> cleared your request';

            switch (auth()->user()->role->name) {
                case 'head_of_department':
                    $u['hod_check'] = $request->decision;
                    $checkedby = 'hod_check';
                    break;

                case 'director_of_student_affairs':
                    $u['student_affair_check'] = $request->decision;
                    $checkedby = 'student_affair_check';
                    break;

                case 'chief_of_library':
                    $u['library_check'] = $request->decision;
                    $checkedby = 'library_check';
                    break;

                case 'admission_officer':
                    $u['adm_reg_check'] = $request->decision;
                    $checkedby = 'adm_reg_check';
                    break;

                case 'income_controller':
                    $u['finance_check'] = $request->decision;
                    $checkedby = 'finance_check';
                    break;
            }

            $data['checking'] = $checkedby;

            $clearance->update($u);

            Notification::create($data);
        } else {
            $u['status'] = RequestStatus::REFUSED;
            switch (auth()->user()->role->name) {
                case 'head_of_department':
                    $u['hod_check'] = $request->decision;
                    $checkedby = 'hod_check';
                    break;

                case 'director_of_student_affairs':
                    $u['student_affair_check'] = $request->decision;
                    $checkedby = 'student_affair_check';
                    break;

                case 'chief_of_library':
                    $u['library_check'] = $request->decision;
                    $checkedby = 'library_check';
                    break;

                case 'admission_officer':
                    $u['adm_reg_check'] = $request->decision;
                    $checkedby = 'adm_reg_check';
                    break;

                case 'income_controller':
                    $u['finance_check'] = $request->decision;
                    $checkedby = 'finance_check';
                    break;
            }

            $clearance->update($u);

            $data['checking'] = $checkedby;
            $data['created_by'] = auth()->user()->id;
            $data['date'] = date('Y-m-d');
            $data['time'] = date('H:i');
            $data['request_id'] = $request->request_id;
            $data['message'] = '* <b>'.auth()->user()->role->display_name .'</b> refused your application';

            Notification::create($data);
        }

        $tim = date('H:i:s');
        $endtim = strtotime("+3 minutes", strtotime($tim));
        $fintim = date('H:i:s', $endtim);

        if(auth()->user()->role->name == 'head_of_department') {
            $checkedby = 'hod_check';
        }
        if(auth()->user()->role->name == 'director_of_student_affairs') {
            $checkedby = 'student_affair_check';
        }
        if(auth()->user()->role->name == 'chief_of_library') {
            $checkedby = 'library_check';
        }
        if(auth()->user()->role->name == 'admission_officer') {
            $checkedby = 'adm_reg_check';
        }
        if(auth()->user()->role->name == 'income_controller') {
            $checkedby = 'finance_check';
        }

        $data2['checking'] = $checkedby;
        $data2['created_by'] = auth()->user()->id;
        $data2['date'] = date('Y-m-d');
        $data2['time'] = $fintim;
        $data2['request_id'] = $request->request_id;
        $data2['message'] = '* '. $request->message;

        Notification::create($data2);

        if(!empty($u['finance_check']) && $u['finance_check'] == 1)
        {
            $u3['status'] = RequestStatus::APPROVED;
            $clearance->update($u3);

            $tim = date('H:i:s');
            $endtim = strtotime("+5 minutes", strtotime($tim));
            $fintim = date('H:i:s', $endtim);

            $data3['checkedby'] = '';
            $data3['created_by'] = 1;
            $data3['date'] = date('Y-m-d');
            $data3['time'] = $fintim;
            $data3['request_id'] = $request->request_id;
            $data3['message'] = '* Your application was approved <br>* Your <b>Clearance</b> is now ready!';

            Notification::create($data3);
        }

        return redirect()->route('student.clearance.request')
            ->withSuccess('Request successfully updated');
    }

    public function CheckResults($id, $regno, $my_check) 
    {
        $res['request_id'] = $id;
        $results = Result::where('regno', $regno)->get();
        $clearance = Clearance::where('id', $id)->first();

        if($clearance->$my_check == 1) {
            abort(404);
        }

        $res['year1_term1'] = 0;
        $res['year1_term2'] = 0;
        $res['year2_term1'] = 0;
        $res['year2_term2'] = 0;
        $res['year3_term1'] = 0;
        $res['year3_term2'] = 0;

        $res['sys_decision'] = '';
        $res['sys_code'] = '';

        foreach ($results as $key => $result) {
            if ($result->level == '1' && $result->term == '1') {
                $res['year1_term1'] = $result->marks;
            }
            if ($result->level == '1' && $result->term == '2') {
                $res['year1_term2'] = $result->marks;
            }
            if ($result->level == '2' && $result->term == '1') {
                $res['year2_term1'] = $result->marks;
            }
            if ($result->level == '2' && $result->term == '2') {
                $res['year2_term2'] = $result->marks;
            }
            if ($result->level == '3' && $result->term == '1') {
                $res['year3_term1'] = $result->marks;
            }
            if ($result->level == '3' && $result->term == '2') {
                $res['year3_term2'] = $result->marks;
            }
        }

        // Year one
        if ($res['year1_term1'] !=0 && $res['year1_term2'] !=0) {
            $res['y1code'] = 'success';
            $res['y1note'] = 'Completed';
        } elseif($res['year1_term1'] !=0 || $res['year1_term2'] !=0) {
            $res['y1code'] = 'warming';
            $res['y1note'] = 'Not Completed';
        } else {
            $res['y1code'] = 'danger';
            $res['y1note'] = '-';
        }

        // Year two
        if ($res['year2_term1'] !=0 && $res['year2_term2'] !=0) {
            $res['y2code'] = 'success';
            $res['y2note'] = 'Completed';
        } elseif($res['year2_term1'] !=0 || $res['year2_term2'] !=0) {
            $res['y2code'] = 'warming';
            $res['y2note'] = 'Not Completed';
        } else {
            $res['y2code'] = 'danger';
            $res['y2note'] = '-';
        }

        // Year three
        if ($res['year3_term1'] !=0 && $res['year3_term2'] !=0) {
            $res['y3code'] = 'success';
            $res['y3note'] = 'Completed';
        } elseif($res['year3_term1'] !=0 || $res['year3_term2'] !=0) {
            $res['y3code'] = 'warming';
            $res['y3note'] = 'Not Completed';
        } else {
            $res['y3code'] = 'danger';
            $res['y3note'] = '-';
        }

        $res['total_yr1'] = ($res['year1_term1'] + $res['year1_term2']) /2;
        $res['total_yr2'] = ($res['year2_term1'] + $res['year2_term2']) /2;
        $res['total_yr3'] = ($res['year3_term1'] + $res['year3_term2']) /2;

        $x = 1;

        $dec1 = false;
        $dec2 = false;
        $dec3 = false;

        while($x <= $clearance->level) {
            if($x == 1 && $res['total_yr1'] != 0) {
                if($clearance->reason == 'graduation' && $res['total_yr1'] < 50)
                    $dec1 = false;
                else
                    $dec1 = true;
            }
            if($x == 2 && $res['total_yr2'] != 0) {
                if($clearance->reason == 'graduation' && $res['total_yr2'] < 50)
                    $dec2 = false;
                else
                    $dec2 = true;
            }
            if($x == 3 && $res['total_yr3']) {
                if($clearance->reason == 'graduation' && $res['total_yr3'] < 50)
                    $dec3 = false;
                else
                    $dec3 = true;
            }

            $x += 1;
        }

        if ($clearance->level == 1) {
            if($dec1) {
                $res['sys_decision'] = 'Results is clear';
                $res['sys_code'] = 'success';
            } else {
                $res['sys_decision'] = 'Results is not clear';
                $res['sys_code'] = 'danger';
            }
        }
        if ($clearance->level == 2) {
            if($dec1 && $dec2) {
                $res['sys_decision'] = 'Results is clear';
                $res['sys_code'] = 'success';
            } else {
                $res['sys_decision'] = 'Results is not clear';
                $res['sys_code'] = 'danger';
            }
        }
        if ($clearance->level == 3) {
            if($dec1 && $dec2 && $dec3) {
                $res['sys_decision'] = 'Results is clear';
                $res['sys_code'] = 'success';
            } else {
                $res['sys_decision'] = 'Results is not clear';
                $res['sys_code'] = 'danger';
            }
        }

        return $res;
    }

    public function CheckHostels($id, $regno, $check_before, $my_check)
    {
        $res['request_id'] = $id;
        $hostels = Hostel::where('regno', $regno)->get();
        $clearance = Clearance::where('id', $id)->first();

        if($clearance->$check_before == 0 || $clearance->my_check == 1) {
            abort(404);
        }

        $res['y1code'] = '';
        $res['y1note'] = '';
        $res['y1debt'] = 0;
        $res['y2code'] = '';
        $res['y2note'] = '';
        $res['y2debt'] = 0;
        $res['y3code'] = '';
        $res['y3note'] = '';
        $res['y3debt'] = 0;

        foreach ($hostels as $key => $hostel) {
            if ($hostel->level == '1') {
                $res['y1debt'] = $hostel->expected_amount - $hostel->amount_paid;
                if ($res['y1debt'] <= 0){
                    $res['y1note'] = 'CLear';
                    $res['y1code'] = 'success';
                    $res['sys_decision'] = 'Hostel is clear';
                    $res['sys_code'] = 'success';
                } else {
                    $res['y1note'] = 'Has debt';
                    $res['y1code'] = 'danger';
                    $res['sys_decision'] = 'Hostel is not clear';
                    $res['sys_code'] = 'danger';
                }
            }
            if ($hostel->level == '2') {
                $res['y2debt'] = $hostel->expected_amount - $hostel->amount_paid;
                if ($res['y2debt'] <= 0) {
                    $res['y2note'] = 'CLear';
                    $res['y2code'] = 'success';
                    $res['sys_decision'] = 'Hostel is clear';
                    $res['sys_code'] = 'success';
                } else {
                    $res['y2note'] = 'Has debt';
                    $res['y2code'] = 'danger';
                    $res['sys_decision'] = 'Hostel is not clear';
                    $res['sys_code'] = 'danger';
                }
            }
            if ($hostel->level == '3') {
                $res['y3debt'] = $hostel->expected_amount - $hostel->amount_paid;
                if ($res['y3debt'] <= 0) {
                    $res['y3note'] = 'CLear';
                    $res['y3code'] = 'success';
                    $res['sys_decision'] = 'Hostel is clear';
                    $res['sys_code'] = 'success';
                } else {
                    $res['y3note'] = 'Has debt';
                    $res['y3code'] = 'danger';
                    $res['sys_decision'] = 'Hostel is not clear';
                    $res['sys_code'] = 'danger';
                }
            }
        }

        return $res;
    }

    public function CheckLibrary ($id, $regno, $check_before, $my_check)
    {
        $res['request_id'] = $id;
        $res['unreturned'] = 0;
        $res['submitted'] = false;
        $res['submittednote'] = false;
        $res['subnote'] = '';

        $libraries = Library::where('regno', $regno)->get();
        $clearance = Clearance::where('id', $id)->first();

        if($clearance->$check_before == 0 || $clearance->my_check == 1) {
            abort(404);
        }

        foreach ($libraries as $key => $library) {
            if($library->type =='borrowed' && $library->status !='Returned')
            {
                $res['unreturned'] +=1;
            }
            if($library->type =='finalbook' && $library->status =='submitted')
            {
                $res['submitted'] = true;
                $res['subcode'] = 'success';
            } else {
                $res['subcode'] = 'danger';
            }
        }

        if ($res['unreturned'] > 0) {
            $res['uncode'] = 'danger';
            $res['sys_decision'] = 'Library is not clear';
            $res['sys_code'] = 'danger';
        } else {
            $res['uncode'] = 'success';
            $res['sys_decision'] = 'Library is clear';
            $res['sys_code'] = 'success';
        }

        if(!empty($clearance)) {
            if($clearance->level == '3' && $res['submittednote']) {
                $res['subnote'] = 'Not yet submitted and he/she must do it';
                $res['sys_decision'] = 'Library is not clear, He/she must submit final year book';
                $res['sys_code'] = 'danger';
            } else {
                $res['subcode'] = 'warning';
                $res['subnote'] = 'Not yet submitted and he/she is still in year '.$clearance->level;
            }
        }

        return $res;
    }

    public function CheckRegistration($id, $regno, $check_before, $my_check)
    {
        $res['request_id'] = $id;
        $registrations = Registration::where('regno', $regno)->orderBy('id', 'ASC')->get();
        $clearance = Clearance::where('id', $id)->first();

        if($clearance->$check_before == 0 || $clearance->my_check == 1) {
            abort(404);
        }

        $res['y1code'] = '';
        $res['y1note'] = '';
        $res['y1aca'] = '';

        $res['y2code'] = '';
        $res['y2note'] = '';
        $res['y2aca'] = '';

        $res['y3code'] = '';
        $res['y3note'] = '';
        $res['y3aca'] = '';

        $dec1 = false;
        $dec2 = false;
        $dec3 = false;

        foreach ($registrations as $key => $registration) {
            if($registration->level == '1') {
                $res['y1code'] = 'success';
                $res['y1note'] = 'Registered';
                $res['y1aca'] = 'Academic Year: '. ($registration->academic_year -1) .'-'.$registration->academic_year;
                $dec1 = true;
            } elseif($clearance->level == 1) {
                $res['y1code'] = 'danger';
                $res['y1note'] = 'Not Registered';
                $dec1 = false;
            }

            if($registration->level == '2'){
                $res['y2code'] = 'success';
                $res['y2note'] = 'Registered';
                $res['y2aca'] = 'Academic Year: '. ($registration->academic_year -1) .'-'.$registration->academic_year;
                $dec2 = true;
            } elseif($clearance->level == 2) { 
                $res['y2code'] = 'danger';
                $res['y2note'] = 'Not Registered';
                $dec2 = false;
            }

            if($registration->level == '3'){
                $res['y3code'] = 'success';
                $res['y3note'] = 'Registered';
                $res['y3aca'] = 'Academic Year: '. ($registration->academic_year -1) .'-'.$registration->academic_year;
                $dec3 = true;
            } elseif($clearance->level == 3) {
                $res['y3code'] = 'danger';
                $res['y3note'] = 'Not Registered';
                $dec3 = false;
            }
        }

        if ($clearance->level == 1) {
            if($dec1) {
                $res['sys_decision'] = 'Registration is clear';
                $res['sys_code'] = 'success';
            } else {
                $res['sys_decision'] = 'Registration is not clear';
                $res['sys_code'] = 'danger';
            }
        }
        if ($clearance->level == 2) {
            if($dec1 && $dec2) {
                $res['sys_decision'] = 'Registration is clear';
                $res['sys_code'] = 'success';
            } else {
                $res['sys_decision'] = 'Registration is not clear';
                $res['sys_code'] = 'danger';
            }
        }
        if ($clearance->level == 3) {
            if($dec1 && $dec2 && $dec3) {
                $res['sys_decision'] = 'Registration is clear';
                $res['sys_code'] = 'success';
            } else {
                $res['sys_decision'] = 'Registration is not clear';
                $res['sys_code'] = 'danger';
            }
        }

        return $res;
    }

    public function CheckFinance($id, $regno, $check_before, $my_check)
    {
        $res['request_id'] = $id;
        $finances = Finance::where('regno', $regno)->get();
        $clearance = Clearance::where('id', $id)->first();

        if($clearance->$check_before == 0 || $clearance->my_check ==1) {
            abort(404);
        }

        $res['y1code'] = '';
        $res['y2code'] = '';
        $res['y3code'] = '';
        $res['y1note'] = '';
        $res['y2note'] = '';
        $res['y3note'] = '';
        $res['y1note2'] = '';
        $res['y2note2'] = '';
        $res['y3note2'] = '';

        $res['y1x'] = 0;
        $res['y2x'] = 0;
        $res['y3x'] = 0;
        $res['total_yr1'] = 0;
        $res['total_yr2'] = 0;
        $res['total_yr3'] = 0;

        $res['sys_decision'] = '';
        $res['sys_code'] = '';

        foreach ($finances as $key => $finance) {
            if($finance->level == 1) {
                $res['y1x'] = $finance->expected_amount;
                $res['y1note'] .= '* Rwf '. $finance->amount_paid .'<br> ';
                $res['total_yr1'] += $finance->amount_paid;
            }
            if($finance->level == 2) {
                $res['y2x'] = $finance->expected_amount;
                $res['y2note'] .= '* Rwf '. $finance->amount_paid .'<br> ';
                $res['total_yr2'] += $finance->amount_paid;
            }
            if($finance->level == 3) {
                $res['y3x'] = $finance->expected_amount;
                $res['y3note'] .= '* Rwf '. $finance->amount_paid .'<br> ';
                $res['total_yr3'] += $finance->amount_paid;
            }
        }

        if($res['total_yr1'] >= $res['y1x']) {
            $res['y1code'] = 'success';
            $res['y1note2'] = 'Full paid';
        } else {
            $res['y1note2'] = 'Not paid';
            $res['y1code'] = 'danger';
        }

        if($res['total_yr2'] >= $res['y2x']) {
            $res['y2code'] = 'success';
            $res['y2note2'] = 'Full paid';
        } else {
            $res['y2note2'] = 'Not paid';
            $res['y2code'] = 'danger';
        }

        if($res['total_yr3'] >= $res['y3x']) {
            $res['y3code'] = 'success';
            $res['y3note2'] = 'Full paid';
        } else {
            $res['y3note2'] = 'Not paid';
            $res['y3code'] = 'danger';
        }


        if ($res['total_yr1'] == 0){
            $res['y1note2'] = '-';
            $res['y1code'] = 'warning';
        }
        if ($res['total_yr2'] == 0){
            $res['y2note2'] = '-';
            $res['y2code'] = 'warning';
        }
        if ($res['total_yr3'] == 0){
            $res['y3note2'] = '-';
            $res['y3code'] = 'warning';
        }

        $x = 1;

        $dec1 = false;
        $dec2 = false;
        $dec3 = false;

        while($x <= $clearance->level) {
            if($x == 1 && $res['total_yr1'] != 0 && $res['total_yr1'] >= $res['y1x']) {
                $dec1 = true;
            }
            if($x == 2 && $res['total_yr2'] != 0 && $res['total_yr2'] >= $res['y2x']) {
                $dec2 = true;
            }
            if($x == 3 && $res['total_yr3'] != 0 && $res['total_yr3'] >= $res['y3x']) {
                $dec3 = true;
            }

            $x += 1;
        }

        if ($clearance->level == 1) {
            if($dec1) {
                $res['sys_decision'] = 'Finance is clear';
                $res['sys_code'] = 'success';
            } else {
                $res['sys_decision'] = 'Finance is not clear';
                $res['sys_code'] = 'danger';
            }
        }
        if ($clearance->level == 2) {
            if($dec1 && $dec2) {
                $res['sys_decision'] = 'Finance is clear';
                $res['sys_code'] = 'success';
            } else {
                $res['sys_decision'] = 'Finance is not clear';
                $res['sys_code'] = 'danger';
            }
        }
        if ($clearance->level == 3) {
            if($dec1 && $dec2 && $dec3) {
                $res['sys_decision'] = 'Finance is clear';
                $res['sys_code'] = 'success';
            } else {
                $res['sys_decision'] = 'Finance is not clear';
                $res['sys_code'] = 'danger';
            }
        }

        return $res;
    }
}