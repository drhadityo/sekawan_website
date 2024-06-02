<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Spatie\Activitylog\Facades\LogBatch;


class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        $title = "Daftar Dokumen"; 
        return view('admin.document.index', compact('documents', 'title'));
    }


    public function create()
    {
        return view('admin.document.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,xlsx,xls,ppt,pptx|max:10240',

        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName);
        LogBatch::startBatch();
        Document::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
        ]);
        LogBatch::endBatch();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function show(Document $document)
    {
        return view('admin.document.show', compact('document'));
    }

    public function edit(Document $document)
    {
        return view('admin.document.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $document->update($request->all());

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        LogBatch::startBatch();
        $document->delete();
        if (request()->ajax()) {
            return true;
        };
        LogBatch::endBatch();
        return to_route('admin.documents.index');
    }


}