<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;


class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengeluaran = Pengeluaran::all();
  
        return response()->json($pengeluaran);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $get_pengeluaran = $request->all();
            $pengeluaran = new Pengeluaran();
            $pengeluaran->nama = $get_pengeluaran['nama'];
            $pengeluaran->tgl_pengeluaran = $get_pengeluaran['tgl_pengeluaran'];
            $pengeluaran->jenis_pengeluaran = $get_pengeluaran['jenis_pengeluaran'];
            $pengeluaran->nominal = $get_pengeluaran['nominal'];
            $pengeluaran->keterangan = $get_pengeluaran['keterangan'];
            $pengeluaran->save();
            return response()->json($pengeluaran);
        } catch(ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
                'errors' => $exception->errors(),
            ], 500);
        }
        
  
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        return response()->json($pengeluaran);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->nama = $request->nama;
        $pengeluaran->tgl_pengeluaran = $request->tgl_pengeluaran;
        $pengeluaran->jenis_pengeluaran = $request->jenis_pengeluaran;
        $pengeluaran->nominal = $request->nominal;
        $pengeluaran->keterangan = $request->keterangan;
        $pengeluaran->update();
  
        return response()->json($pengeluaran);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pengeluaran::destroy($id);
  
        return response()->json(['message' => 'Deleted']);
    }

    public function getPengeluaranByDate(Request $request, $id) {

        $jenis = ['gaji', 'operasional', 'produksi'];

        $jsonobj = '{"gaji":0,"operasional":0,"produksi":0}';
        $arr = json_decode($jsonobj, true);
        try{
            $pengeluaran = Pengeluaran::where('tgl_pengeluaran', $id)->get();
            foreach($jenis as $jns) {
                $pengeluaranByJenis = $pengeluaran->where('jenis_pengeluaran', $jns)->sum('nominal');
                $arr[$jns] = $pengeluaranByJenis;
            }
            $total_nominal = $pengeluaran->sum('nominal');
            $total_data = $pengeluaran->count();
            return response()->json([
                'nominal_jenis' => $arr,
                'total_pengeluaran' => $total_nominal,
                'jumlah_data' => $total_data,
                'data' => $pengeluaran
            ]
            );
        } catch(ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
                'errors' => $exception->errors(),
            ], 500);
        }
    }
}
