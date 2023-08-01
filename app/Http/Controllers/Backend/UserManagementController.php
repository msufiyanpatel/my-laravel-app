<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\ValidImageType;
use App\Models\ConversionHistory;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\ImageHandlerController;
use Carbon\Carbon;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('type', 'User')->get();

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn(
                    'thumb',
                    '<img class="img-fluid" src="{{ $pro_pic }}" width="50" alt="{{ $name }}">'
                )
                ->addColumn('created', function ($data) {
                    return date('d M, Y', strtotime($data->created_at));
                })
                ->addColumn(
                    'action',
                    '<div class="action-wrapper">
                        <a class="btn btn-sm bg-gradient-primary"
                            href="{{ route(\'backend.admin.user.history\', $id) }}">
                            <i class="fas fa-history"></i>
                            Convert History
                        </a>
                        @if ($is_suspended)
                            <a class="btn btn-sm bg-gradient-success"
                                href="{{ route(\'backend.admin.user.suspend\', [\'id\' => $id, \'status\' => 0]) }}">
                                <i class="fas fa-check-square"></i>
                                Activate
                            </a>
                        @else
                            <a class="btn btn-sm bg-gradient-danger"
                                href="{{ route(\'backend.admin.user.suspend\', [\'id\' => $id, \'status\' => 1]) }}"
                                onclick="return confirm(\'Are you sure ?\')">
                                <i class="far fa-times-circle"></i>
                                Suspend
                            </a>
                        @endif
                    </div>'
                )
                ->addColumn('suspend', function ($data) {
                    if ($data->is_suspended == 0) {
                        return '<span class="badge badge-pill badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-pill badge-danger">Suspended</span>';
                    }
                })
                ->rawColumns(['thumb', 'created', 'action', 'suspend'])
                ->toJson();
        }

        return view('backend.users.index');
    }

    public function suspend($id, $status)
    {
        $user = User::findOrFail($id);

        if ($user->is_suspended == $status) {
            return back()->with('error', 'User already suspended');
        } else {
            $user->is_suspended = $status;
            $user->save();

            return back()->with('success', 'User suspended successfully');
        }
    }

    public function history(Request $request, $user_id)
    {
        if ($request->ajax()) {
            $history = ConversionHistory::with('items')
                ->where('user_id', $user_id)
                ->latest()
                ->get();

            return DataTables::of($history)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    return date('d M, Y', strtotime($data->created_at));
                })
                ->addColumn('items', function ($data) {
                    $data_set = '<ul class="px-5">';
                    foreach ($data->items as $value) {
                        $data_set .= '
                            <li class="p-1">
                                <a href="' . $value->converted . '" target="_blank" title="Download: ' . $value->file_name . '">
                                    ' . $value->file_name . '
                                </a>
                                <a href="' . $value->converted . '" target="_blank" download="' . $value->file_name . '" title="Download"
                                    class="btn btn-sm bg-primary">
                                    Download
                                </a>
                            </li>';
                    }
                    $data_set .= '</ul>';

                    return $data_set;
                })
                ->rawColumns(['created_at', 'items'])
                ->toJson();
        }

        return view('backend.users.user-history', compact('user_id'));
    }

    public function conversionHistory(Request $request)
    {
        $history = ConversionHistory::with(['items', 'user'])
            ->latest()
            ->get();

        if ($request->ajax()) {
            return DataTables::of($history)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    return date('d M, Y', strtotime($data->created_at));
                })
                ->addColumn('user', function ($data) {
                    if ($data->user) {
                        return $data->user->name . '<br>' . $data->user->email;
                    } else {
                        return 'Anonymous';
                    }
                })
                ->addColumn('items', function ($data) {
                    $data_set = '<ul class="px-5">';
                    foreach ($data->items as $value) {
                        $data_set .= '
                            <li class="p-1">
                                <a href="' . $value->converted . '" target="_blank" title="Download: ' . $value->file_name . '">
                                    ' . $value->file_name . '
                                </a>
                                <a href="' . $value->converted . '" target="_blank" download="' . $value->file_name . '" title="Download"
                                    class="btn btn-sm bg-primary">
                                    Download
                                </a>
                                <a href="' . route('delete.image', routeEncrypt($value->id)) . '"
                                    class="btn btn-sm bg-danger">
                                    Download
                                </a>
                            </li>';
                    }
                    $data_set .= '</ul>';

                    return $data_set;
                })
                ->rawColumns(['created_at', 'items', 'user'])
                ->toJson();
        }

        $total = $history->count();
        $today = ConversionHistory::whereDate('created_at', today())->count();
        return view('backend.users.conversion-history', compact('total', 'today'));
    }
}
