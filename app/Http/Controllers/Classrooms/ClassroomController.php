<?php


namespace App\Http\Controllers\Classrooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassroom;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{

    /*** Index Function ***/
    public function index(Request $request)
    {
        if ($request->Grade_id == 'all' || !$request->Grade_id){
            $My_Classes = Classroom::all();
        }
        else{
            $My_Classes = Classroom::select('*')->where('Grade_id','=',$request->Grade_id)->get();
        }
        $Grades = Grade::all();
        return view('pages.My_Classes.My_Classes',compact('Grades','My_Classes'));
    }



    /*** Store Function ***/
    public function store(StoreClassroom $request)
    {
        $List_Classes = $request->List_Classes;
        try {
            $validated = $request->validated();
            foreach ($List_Classes as $List_Class)
            {
                $My_Classes = new Classroom();
                $My_Classes->Name_Class = ['en' => $List_Class['Name_class_en'], 'ar' => $List_Class['Name']];
                $My_Classes->Grade_id = $List_Class['Grade_id'];
                $My_Classes->save();
            }
            toastr()->success(trans('messages.success'));
            return redirect()->route('Classrooms.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }



    /*** Update Function ***/
    public function update(Request $request)
    {
        try {
            $Classrooms = Classroom::findOrFail($request->id);
            $Classrooms->update([
                $Classrooms->Name_Class = ['ar' => $request->Name, 'en' => $request->Name_en],
                $Classrooms->Grade_id = $request->Grade_id,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Classrooms.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    /*** Destroy Function ***/
    public function destroy(Request $request)
    {
        $Classrooms = Classroom::findOrFail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Classrooms.index');
    }



    /*** Delete_all Function ***/
    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);
        Classroom::whereIn('id', $delete_all_id)->Delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Classrooms.index');
    }



    /*** Filter_Classes Function ***/
   /* public function Filter_Classes(Request $request)
    {
        if ($request->Grade_id == 'all'){
            $Search = Classroom::all();
        }
        else{
            $Search = Classroom::select('*')->where('Grade_id','=',$request->Grade_id)->get();
        }
        $Grades = Grade::all();
        return view('pages.My_Classes.My_Classes',compact('Grades'))->withDetails($Search);
    }
*/

} //end of class


