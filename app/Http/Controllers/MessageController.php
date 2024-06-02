<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Http\Requests\MessageRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function create()
    {
        return view('web.pesan');
    }

    public function store(MessageRequest $request)
    {
        $message = Message::create($request->validated());
        $numbers = User::whereNotNull('number')->pluck('number')->implode(',');
        $fileLink = '';
    
        if ($request->hasFile('file')) {
            $message->saveFile($request->file('file'));
            $filePath = $message->file_path;
            $fileLink = url('storage/' . $filePath);
        }
    
        $text = "[Pesan Otomatis Sekawan's TB Jember]\n\nHalo, Anda menerima pesan baru dari: \n\nNama: " . $request->nama . "\nNo Telepon: " . $request->nomor . "\nInstansi: " . $request->instansi . "\nKeperluan: " . $request->keperluan;

        if (!empty($fileLink)) {
            $text .= "\nFile Terlampir: " . $fileLink;
        } else {
            $text .= "\nFile Kosong";
        }

        $text .= "\n\nSilakan cek halaman pesan pada admin: www.sekawantb.com/admin/messages \n\nTerima kasih.";

        $this->sendFonnteMessage($numbers, $text);
    
        return redirect()->route('pesan.create')->with('success', 'Pesan berhasil dikirim.');
    }

    private function sendFonnteMessage($numbers, $text)
    {
        // Menghapus angka 0 di awal nomor 
        $numbers = ltrim($numbers, '0');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $numbers,
                'message' => $text,
                'delay' => '10',
                'countryCode' => '62', 
            ),

            // Token Fonnte masukkan disini
            CURLOPT_HTTPHEADER => array(
                'Authorization: FQHuH6RsnbHdJ4Pqx4NE'  
            ),
        ));
    

        $response = curl_exec($curl);

        curl_close($curl);

        // Parsing json response
        $responseData = json_decode($response, true);

        return [
            'success' => isset($responseData['status']) && $responseData['status'] === 'success',
            'response' => $responseData
        ];
    }

    public function index()
    {
        $messages = Message::all();
        return view('admin.message.index', compact('messages'));
    }

    public function show($id)
    {
        $message = Message::findOrFail($id);
        return view('messages.show', compact('message'));
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete(); 

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil dihapus.'
        ]);
    }

    public function restore($id)
    {
        $message = Message::withTrashed()->findOrFail($id);
        
        if ($message->trashed()) {
            $message->restore();

            return response()->json([
                'status' => 'success',
                'message' => 'Pesan berhasil direstore.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesan tidak ditemukan atau tidak dihapus.'
            ], 404);
        }
    }

}
