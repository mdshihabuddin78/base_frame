<?php

namespace App\Http\Controllers\RBAC;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Permission;
use App\Models\RoleModules;
use Illuminate\Http\Request;
use function Symfony\Component\Finder\in;

class ModuleController extends Controller
{
    use Helper;

    public function __construct()
    {
        $this->model = new Module();
        $this->childModel = new Permission();

        $this->middleware(function ($request, $next) {
            if (!can(request()->route()->action['as'])){
                return returnData(5001, null, 'You are not authorized to access this page');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $keyword = input('keyword');

        $data = $this->model->where('parent_id', 0)
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'Like', "%$keyword%");
                $query->orWhere('display_name', 'Like', "%$keyword%");
            })
            ->with('permissions')
            ->with(['submenus'=>function($query) use ($keyword){
                $query->when($keyword, function ($query) use ($keyword) {
                    $query->where('name', 'Like', "%$keyword%");
                    $query->orWhere('display_name', 'Like', "%$keyword%");
                });
                $query->with('permissions');

                $query->with(['submenus'=>function($query) use ($keyword){
                    $query->when($keyword, function ($query) use ($keyword) {
                        $query->where('name', 'Like', "%$keyword%");
                        $query->orWhere('display_name', 'Like', "%$keyword%");
                    });
                    $query->with('permissions');
                }]);
            }])
            ->paginate(input('perPage'));

        return returnData(2000, $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validate = $this->model->validate($input);

        if ($validate->fails()) {
            return returnData(2000, $validate->errors());
        }

        $this->model->fill($input);
        $this->model->save();

        return returnData(2000, null, 'Successfully Inserted');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validate = $this->model->validate($input);
        if ($validate->fails()) {
            return returnData(2000, $validate->errors());
        }

        $old_module = $this->model->where('id', $request->id)->first();
        $module = $this->model->where('id', $request->id)->first();

        if ($module) {
            $module->fill($input);
            $module->save();
        }

        return returnData(2000, null, 'Successfully Inserted');
    }

    public function status()
    {
        try {
            $data = $this->model->where('id', request()->input('id'))->first();

            if (!$data) {
                return returnData(2000, null, 'Data Not found');
            }

            if ($data->status == 1) {
                $data->status = 0;
                $data->save();

                $this->model->where('parent_id', $data->id)->update([
                    'status' => 0
                ]);

                return returnData(2000, 'warning', "Successfully InActivated");
            } else {
                $data->status = 1;
                $data->save();

                return returnData(2000, 'success', "Successfully Activated");
            }

        } catch (\Exception $exception) {
            return returnData(5000, $exception->getMessage(), 'Not Updated');
        }
    }


    public function destroy($id)
    {
        $user = $this->model->where('id', $id)->first();

        if ($user) {
            $user->delete();

            $this->childModel->where('module_id', $user->id)->delete();
            RoleModules::where('module_id', $user->id)->delete();

            return returnData(2000, $user, 'Successfully Deleted');
        }

        return returnData(5000, null, 'Data Not found');
    }
}
