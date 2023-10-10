<?php


namespace App\Http\Controllers\Grades;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

use App\Http\Requests\StoreGrades;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{

 /*** Index Function ***/
  public function index()
  {
      $Grades = Grade::all();
    return view('pages.Grades.Grades',compact('Grades'));
  }



  /*** Store Function ***/
  public function store(StoreGrades $request)
  {
    try {
          $validated = $request->validated();
          $Grade = new Grade();
          /*
          $translations = [
              'en' => $request->Name_en,
              'ar' => $request->Name
          ];
          $Grade->setTranslations('Name', $translations);
          */
          $Grade->Name = ['en' => $request->Name_en, 'ar' => $request->Name];
          $Grade->Notes = $request->Notes;
          $Grade->save();
          toastr()->success(trans('messages.success'));
          return redirect()->route('Grades.index');
      }
      catch (\Exception $e){
          return redirect()->back()->withErrors(['error' => $e->getMessage()]);
      }
  }



  /*** Update Function ***/
 public function update(StoreGrades $request)
 {
   try {
       $validated = $request->validated();
       $Grades = Grade::findOrFail($request->id);
       $Grades->update([
         $Grades->Name = ['ar' => $request->Name, 'en' => $request->Name_en],
         $Grades->Notes = $request->Notes,
       ]);
       toastr()->success(trans('messages.Update'));
       return redirect()->route('Grades.index');
   }
   catch (\Exception $e) {
       return redirect()->back()->withErrors(['error' => $e->getMessage()]);
   }
 }



  /*** Destroy Function ***/
  public function destroy(Request $request)
  {
      $MyClass_id = Classroom::where('Grade_id',$request->id)->pluck('Grade_id');

      if($MyClass_id->count() == 0){

          $Grades = Grade::findOrFail($request->id)->delete();
          toastr()->error(trans('messages.Delete'));
          return redirect()->route('Grades.index');
      }
      else{
          toastr()->error(trans('Grades_trans.delete_Grade_Error'));
          return redirect()->route('Grades.index');
      }
  }


} //end of class
