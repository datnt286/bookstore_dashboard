<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Models\Book;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $sliders = Slider::all();

        if ($request->ajax()) {
            return Datatables::of($sliders)
                ->addColumn('action', function ($slider) {
                    return '<div class="project-actions text-right">' .
                        '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' . $slider->id . '" data-toggle="modal" data-target="#modal-store"><i class="fas fa-edit"></i> Cập nhật</button>' .
                        '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $slider->id . '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' .
                        '</div>';
                })
                ->make(true);
        }

        return view('sliders.index', compact('sliders'));
    }

    public function create()
    {
        $books = Book::all();

        return response()->json([
            'success' => true,
            'data' => [
                'books' => $books,
            ],
        ]);
    }

    public function store(CreateSliderRequest $request)
    {
        $slider = Slider::create(
            [
                'name' => $request->name,
                'book_id' => $request->book_id,
                'status' => $request->status,
            ],
        );

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . Str::slug($request->name) . '.' . $extension;

            $file->move(public_path('uploads/sliders/'), $fileName);

            // if ($slider->image && Storage::exists('uploads/sliders/' . $slider->image)) {
            //     Storage::delete('uploads/sliders/' . $slider->image);
            // }

            $slider->image = $fileName;
            $slider->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới slider thành công!',
        ]);
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        $books = Book::all();

        return response()->json([
            'success' => true,
            'data' => [
                'slider' => $slider,
                'books' => $books,
            ],
        ]);
    }

    public function update(UpdateSliderRequest $request)
    {
        $slider = Slider::find($request->id);

        $slider->update(
            [
                'name' => $request->name,
                'book_id' => $request->book_id,
                'status' => $request->status,
            ],
        );

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . Str::slug($request->name) . '.' . $extension;

            $file->move(public_path('uploads/sliders/'), $fileName);

            // if ($slider->image && Storage::exists('uploads/sliders/' . $slider->image)) {
            //     Storage::delete('uploads/sliders/' . $slider->image);
            // }

            $slider->image = $fileName;
            $slider->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật slider thành công!',
        ]);
    }

    public function show($id)
    {
        $slider = Slider::find($id);

        return response()->json([
            'success' => true,
            'data' => $slider,
        ]);
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);
        $slider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá slider thành công!',
        ]);
    }
}
