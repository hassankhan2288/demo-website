<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Unit;
use Illuminate\Validation\Rule;
use Auth;

class UnitController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
        generateBreadcrumb();
    }

    public function index()
    {
        $lims_unit_all = Unit::where('is_active', true)->get();
        return view('admin.partials.unit.create', compact('lims_unit_all'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'unit_code' => [
                'max:255',
                    Rule::unique('units')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            'unit_name' => [
                'max:255',
                    Rule::unique('units')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ]

        ]);
        $input = $request->all();
        $input['is_active'] = true;
        if(!$input['base_unit']){
            $input['operator'] = '*';
            $input['operation_value'] = 1;
        }
        Unit::create($input);
        return redirect('admin/unit');
    }

    public function limsUnitSearch()
    {
        $lims_unit_name = $_GET['lims_unitNameSearch'];
        $lims_unit_all = Unit::where('unit_name', $lims_unit_name)->paginate(5);
        $lims_unit_list = Unit::all();
        return view('backend.unit.create', compact('lims_unit_all','lims_unit_list'));
    }

    public function edit($id)
    {
        $lims_unit_data = Unit::findOrFail($id);
        return $lims_unit_data;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'unit_code' => [
                'max:255',
                    Rule::unique('units')->ignore($request->unit_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'unit_name' => [
                'max:255',
                    Rule::unique('units')->ignore($request->unit_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ]
        ]);

        $input = $request->all();
        $lims_unit_data = Unit::where('id',$input['unit_id'])->first();
        $lims_unit_data->update($input);
        return redirect('admin/unit');
    }

    public function importUnit(Request $request)
    {  
        //get file
        $filename =  $request->file->getClientOriginalName();
        $upload=$request->file('file');
        $filePath=$upload->getRealPath();
        //open and read
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through othe columns
        $lims_unit_data = [];
        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
                continue;
            foreach ($columns as $key => $value) {
                $value=preg_replace('/\D/','',$value);
            }
            $data= array_combine($escapedHeader, $columns);

            $unit = Unit::firstOrNew(['unit_code' => $data['code'],'is_active' => true ]);
            $unit->unit_code = $data['code'];
            $unit->unit_name = $data['name'];
            if($data['baseunit']==null)
                $unit->base_unit = null;
            else{
                $base_unit = Unit::where('unit_code', $data['baseunit'])->first();
                $unit->base_unit = $base_unit->id;
            }
            if($data['operator'] == null)
                $unit->operator = '*';
            else
                $unit->operator = $data['operator'];
            if($data['operationvalue'] == null)
                $unit->operation_value = 1;
            else 
                $unit->operation_value = $data['operationvalue'];
            $unit->save();
        }
        return redirect('admin/unit')->with('message', 'Unit imported successfully');
        
    }

    public function deleteBySelection(Request $request)
    {
        $unit_id = $request['unitIdArray'];
        foreach ($unit_id as $id) {
            $lims_unit_data = Unit::findOrFail($id);
            $lims_unit_data->is_active = false;
            $lims_unit_data->save();
        }
        return 'Unit deleted successfully!';
    }

    public function destroy($id)
    {
        $lims_unit_data = Unit::findOrFail($id);
        $lims_unit_data->is_active = false;
        $lims_unit_data->save();
        return redirect('admin/unit');
    }
}
