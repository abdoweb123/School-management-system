<?php

namespace App\Repository;
use App\Models\Gender;
use App\Models\Specialization;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherRepository implements TeacherRepositoryInterface
{

    /*** getAllTeachers Function ***/
    public function getAllTeachers()
    {
       return Teacher::all();
    }



    /*** Getspecialization Function ***/
    public function Getspecialization()
    {
       return specialization::all();
    }



    /*** GetGender Function ***/
    public function GetGender()
    {
       return Gender::all();
    }



    /*** StoreTeachers Function ***/
    public function StoreTeachers($request)
    {
    try {
        $Teachers = new Teacher();
        $Teachers->email = $request->Email;
        $Teachers->password =  Hash::make($request->Password);
        $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
        $Teachers->Specialization_id = $request->Specialization_id;
        $Teachers->Gender_id = $request->Gender_id;
        $Teachers->Joining_Date = $request->Joining_Date;
        $Teachers->Address = $request->Address;
        $Teachers->save();
        toastr()->success(trans('messages.success'));
        return redirect()->route('Teachers.create');
        }
        catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }



    /*** editTeachers Function ***/
    public function editTeachers($id)
    {
        return Teacher::findOrFail($id);
    }



    /*** UpdateTeachers Function ***/
    public function UpdateTeachers($request)
    {
        try {
            $Teachers = Teacher::findOrFail($request->id);
            $Teachers->email = $request->Email;
            $Teachers->password =  Hash::make($request->Password);
            $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Teachers.index');
        }
        catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }



    /*** DeleteTeachers Function ***/
    public function DeleteTeachers($request)
    {
        Teacher::findOrFail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Teachers.index');
    }



} //end of class
