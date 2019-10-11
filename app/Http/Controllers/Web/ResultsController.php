<?php

namespace App\Http\Controllers\Web;

use Cache;
use App\Http\Controllers\Controller;
use App\Result;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use App\Support\Enum\UserStatus;
use Session;

use App\Repositories\Result\ResultRepository;
use App\Http\Requests\Result\CreateResultRequest;
use App\Http\Requests\Result\UpdateResultRequest;

class ResultsController extends Controller
{
    private $results;

    public function __construct(ResultRepository $results)
    {
        $this->middleware('auth');
        $this->middleware('permission:results.manage');
        $this->results = $results;
    }

    public function index()
    {
        $results = $this->results->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status')
        );

        return view('result.index', compact('results'));
    }

    public function create()
    {
        $edit = false;
        return view('result.add-edit', compact('edit', 'departments'));
    }

    public function store(CreateResultRequest $request)
    {
         // if ($request->input('submit') != null ){

      $file = $request->file('file');
      // dd($file);
      // File Details 

      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();
      $tempPath = $file->getRealPath();
      $fileSize = $file->getSize();
      $mimeType = $file->getMimeType();

      // Valid File Extensions
      $valid_extension = array("csv");

      // 2MB in Bytes
      $maxFileSize = 2097152; 

      // Check file extension
      if(in_array(strtolower($extension),$valid_extension)){

        // Check file size
        if($fileSize <= $maxFileSize){

          // File upload location
          $location = 'upload';

          // Upload file
          $file->move($location,$filename);

          // Import CSV to Database
          $filepath = public_path($location."/".$filename);

          // Reading file
          $file = fopen($filepath,"r");

          $importData_arr = array();
          $i = 0;

          while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
             $num = count($filedata);
             
             // Skip first row (Remove below comment if you want to skip the first row)
             if($i == 0){
                $i++;
                continue; 
             }
             for ($c=0; $c < $num; $c++) {
                $importData_arr[$i][] = $filedata [$c];
             }
             $i++;
          }
          fclose($file);

          // Insert to MySQL database
          foreach($importData_arr as $importData){
           // var_dump($importData);
            $insertData = array(
               "regno"=>$importData[0],
               "level"=>$importData[1],
               "term"=>$importData[2],
               "marks"=>$importData[3]);
            Result::create($insertData);
           // die(1);

          }

          Session::flash('message','Imported Successful.');
        }else{
          Session::flash('message','File too large. File must be less than 2MB.');
        }

      }else{
         Session::flash('message','Invalid File Extension.');
      }


        // Redirect to index
        return redirect()->route('result.create')->withSuccess('Result uploaded');
     }        
        // $this->results->create($request->all());

        // return redirect()->route('result.index')
        //     ->withSuccess('Result created');
        
    public function edit(Result $result)
    {
        $edit = true;
        // $editresult = Result::find($id);
        return view('result.edit', compact('edit', 'result'));
    }

    public function update(Result $result, UpdateResultRequest $request)
    {
        $this->results->update($result->id, $request->all());

        return redirect()->route('result.index')
            ->withSuccess('Result updated');
    }

    public function delete(Result $result)
    {
        // if (! $result->removable) {
        //     throw new NotFoundHttpException;
        // }

        $this->results->delete($result->id);

        Cache::flush();

        return redirect()->route('result.index')
            ->withSuccess('Result deleted');
    }
}