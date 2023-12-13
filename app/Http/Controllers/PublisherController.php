<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $publishers = Publisher::all();

        if ($request->ajax()) {
            return DataTables::of($publishers)
                ->addColumn('action', function ($publishers) {
                    return '<div class="project-actions text-right">' .
                        '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' . $publishers->id . '" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-edit"></i> Cập nhật</button>' .
                        '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $publishers->id . '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' .
                        '</div>';
                })
                ->make(true);
        }

        return view('publishers.index', compact('publishers'));
    }

    public function store(Request $request)
    {
        Publisher::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name]
        );

        $message = $request->id ? 'Cập nhật' : 'Thêm mới';

        return response()->json([
            'success' => true,
            'message' => $message . ' nhà xuất bản thành công',
        ]);
    }

    public function show($id)
    {
        $publisher = Publisher::find($id);

        return response()->json([
            'success' => true,
            'data' => $publisher,
        ]);
    }

    public function destroy($id)
    {
        $publisher = Publisher::find($id);
        $publisher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá nhà xuất bản thành công',
        ]);
    }
}
