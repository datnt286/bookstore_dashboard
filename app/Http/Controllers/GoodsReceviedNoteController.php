<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use App\Models\GoodsReceviedNote;
use App\Models\GoodsReceviedNoteDetail;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodsReceviedNoteController extends Controller
{
    public function index()
    {
        $goodsReceviedNotes = GoodsReceviedNote::all();

        return view('goods-recevied-notes.index', compact('goodsReceviedNotes'));
    }

    public function create()
    {
        $books = Book::all();
        $combos = Combo::all();
        $suppliers = Publisher::all();

        return view('goods-recevied-notes.create', compact('books', 'combos', 'suppliers'));
    }

    public function store(Request $request)
    {
        $total = 0;

        $goodsReceviedNote = GoodsReceviedNote::create([
            'supplier_id' => $request->supplier_id,
            'admin_id' => Auth::user()->id,
            'total' => $total,
        ]);

        for ($i = 0; $i < count($request->book_id); $i++) {
            GoodsReceviedNoteDetail::create([
                'goods_recevied_note_id' => $goodsReceviedNote->id,
                'book_id' => $request->book_id[$i],
                'combo_id' => $request->combo_id[$i],
                'import_price' => $request->import_price[$i],
                'price' => $request->price[$i],
                'quantity' => $request->quantity[$i],
            ]);

            $amount = $request->import_price[$i] * $request->quantity[$i];
            $total += $amount;

            if ($request->book_id[$i]) {
                $book = Book::find($request->book_id[$i]);
                $book->price = $request->price[$i];
                $book->quantity += $request->quantity[$i];
                $book->save();
            }

            if ($request->combo_id[$i]) {
                $combo = Combo::find($request->combo_id[$i]);
                $combo->price = $request->price[$i];
                $combo->quantity += $request->quantity[$i];
                $combo->save();
            }
        }

        GoodsReceviedNote::find($goodsReceviedNote->id)
            ->update(['total' => $total]);

        return response()->json([
            'success' => true,
            'message' => 'Thêm hoá đơn nhập thành công!'
        ]);
    }

    public function show($id)
    {
        $goodsReceviedNoteDetails = GoodsReceviedNoteDetail::with(['book', 'combo'])
            ->where('goods_recevied_note_id', $id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $goodsReceviedNoteDetails
        ]);
    }
}
