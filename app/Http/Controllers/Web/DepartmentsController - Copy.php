<?php

namespace App\Http\Controllers\Web;

use Cache;
use App\Http\Controllers\Controller;
use App\Finance;
use App\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use App\Support\Enum\UserStatus;

use App\Repositories\Finance\FinanceRepository;
use App\Http\Requests\Finance\CreateFinanceRequest;
use App\Http\Requests\Finance\UpdateFinanceRequest;

class FinancesController extends Controller
{
    private $finances;

    public function __construct(FinanceRepository $finances)
    {
        $this->middleware('auth');
        $this->middleware('permission:income.manage');
        $this->finances = $finances;
    }

    public function index()
    {
        $finances = $this->finances->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status')
        );

        $statuses = ['' => 'All'] + UserStatus::lists();

        return view('finance.index', compact('finances', 'statuses'));
    }

    public function create()
    {
        $edit = false;
        $hods = array();
        $users = User::orderBy('first_name', 'asc')->get();

        foreach ($users as $key => $value) {
            if($value->role->name == 'head_of_finance')
                array_push($hods, $value);
        }

        return view('finance.add-edit', compact('edit', 'hods'));
    }

    public function store(CreateFinanceRequest $request)
    {
        $this->finances->create($request->all());

        return redirect()->route('finance.index')
            ->withSuccess('Finance created');
    }

    public function edit(Finance $finance)
    {
        $edit = true;
        $hods = array();
        $users = User::orderBy('first_name', 'asc')->get();

        foreach ($users as $key => $value) {
            if($value->role->name == 'head_of_finance')
                array_push($hods, $value);
        }

        return view('finance.add-edit', compact('edit', 'finance', 'hods'));
    }

    public function update(Finance $finance, UpdateFinanceRequest $request)
    {
        $this->finances->update($finance->id, $request->all());

        return redirect()->route('finance.index')
            ->withSuccess('Finance updated');
    }

    public function delete(Finance $finance)
    {
        // if (! $finance->removable) {
        //     throw new NotFoundHttpException;
        // }

        $this->finances->delete($finance->id);

        Cache::flush();

        return redirect()->route('finance.index')
            ->withSuccess('Finance deleted');
    }
}