<?php

namespace App\Http\Controllers;

use App\Models\JtlPegawaiHasil;
use App\Models\RemunerasiSource;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Exports\JtlPegawaiHasilExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class JtlPegawaiHasilController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = JtlPegawaiHasil::with(['pegawai', 'unitKerja', 'remunerasiSource'])
                ->when($request->remunerasi_source_id, function($q) use ($request) {
                    return $q->where('remunerasi_source', $request->remunerasi_source_id);
                })
                ->when($request->unit_kerja_id, function($q) use ($request) {
                    return $q->where('unit_kerja_id', $request->unit_kerja_id);
                })
                ->when($request->search, function($q) use ($request) {
                    return $q->where(function($query) use ($request) {
                        $query->where('nik', 'like', '%' . $request->search . '%')
                              ->orWhere('nama_pegawai', 'like', '%' . $request->search . '%');
                    });
                });

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('nama_pegawai', function($row) {
                    return $row->nama_pegawai;
                })
                ->addColumn('unit_kerja', function($row) {
                    return $row->unitKerja ? $row->unitKerja->nama : '-';
                })
                ->addColumn('remunerasi_source_name', function($row) {
                    return $row->remunerasiSource ? $row->remunerasiSource->nama : '-';
                })
                ->editColumn('dasar', function($row) {
                    return number_format($row->dasar, 2);
                })
                ->editColumn('kompetensi', function($row) {
                    return number_format($row->kompetensi, 2);
                })
                ->editColumn('resiko', function($row) {
                    return number_format($row->resiko, 2);
                })
                ->editColumn('emergensi', function($row) {
                    return number_format($row->emergensi, 2);
                })
                ->editColumn('posisi', function($row) {
                    return number_format($row->posisi, 2);
                })
                ->editColumn('kinerja', function($row) {
                    return number_format($row->kinerja, 2);
                })
                ->editColumn('jumlah', function($row) {
                    return '<span class="badge bg-primary">' . number_format($row->jumlah, 2) . '</span>';
                })
                ->editColumn('nilai_indeks', function($row) {
                    return number_format($row->nilai_indeks, 2);
                })
                ->editColumn('jtl_bruto', function($row) {
                    return '<span class="text-success fw-bold">Rp ' . number_format($row->jtl_bruto, 0, ',', '.') . '</span>';
                })
                ->editColumn('pajak', function($row) {
                    return $row->pajak ? number_format($row->pajak, 2) . '%' : '0%';
                })
                ->editColumn('potongan_pajak', function($row) {
                    return '<span class="text-warning">Rp ' . number_format($row->potongan_pajak, 0, ',', '.') . '</span>';
                })
                ->editColumn('jtl_net', function($row) {
                    return '<span class="text-info fw-bold">Rp ' . number_format($row->jtl_net, 0, ',', '.') . '</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-warning btn-edit" 
                                    data-url="' . route('jtl-pegawai-hasil.show', $row->id) . '">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" 
                                    data-url="' . route('jtl-pegawai-hasil.destroy', $row->id) . '">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['jumlah', 'jtl_bruto', 'potongan_pajak', 'jtl_net', 'action'])
                ->make(true);
        }

        $remunerasiSources = RemunerasiSource::orderBy('id', 'desc')->get();
        $unitKerja = UnitKerja::orderBy('id', 'desc')->get();
        $pegawai = Pegawai::orderBy('id', 'desc')->get();

        return view('jtl-pegawai-hasil.index', compact('remunerasiSources', 'unitKerja', 'pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'remunerasi_source' => 'required|exists:remunerasi_source,id',
            'nik' => 'required|string|max:50',
            'nama_pegawai' => 'required|string|max:255',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'dasar' => 'required|numeric|min:0|max:99999999.99',
            'kompetensi' => 'required|numeric|min:0|max:99999999.99',
            'resiko' => 'required|numeric|min:0|max:99999999.99',
            'emergensi' => 'required|numeric|min:0|max:99999999.99',
            'posisi' => 'required|numeric|min:0|max:99999999.99',
            'kinerja' => 'required|numeric|min:0|max:99999999.99',
            'nilai_indeks' => 'required|numeric|min:0|max:99999999.99',
            'pajak' => 'nullable|numeric|min:0|max:100',
            'rekening' => 'nullable|string|max:50'
        ]);

        // Check if record already exists
        $existing = JtlPegawaiHasil::where('id_pegawai', $request->id_pegawai)
            ->where('remunerasi_source', $request->remunerasi_source)
            ->first();

        if ($existing) {
            return response()->json([
                'meta' => [
                    'status' => 'error',
                    'message' => 'Data pegawai untuk remunerasi source ini sudah ada!'
                ]
            ], 422);
        }

        // Calculate jumlah
        $jumlah = $request->dasar + $request->kompetensi + $request->resiko + 
                 $request->emergensi + $request->posisi + $request->kinerja;

        $data = $request->all();
        $data['jumlah'] = $jumlah;

        $jtlPegawaiHasil = JtlPegawaiHasil::create($data);

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Data JTL Pegawai Hasil berhasil ditambahkan!'
            ],
            'data' => $jtlPegawaiHasil
        ]);
    }

    public function show($id)
    {
        $jtlPegawaiHasil = JtlPegawaiHasil::with(['pegawai', 'unitKerja', 'remunerasiSource'])->findOrFail($id);

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Data berhasil diambil'
            ],
            'data' => $jtlPegawaiHasil
        ]);
    }

    public function update(Request $request, $id)
    {
        $jtlPegawaiHasil = JtlPegawaiHasil::findOrFail($id);

        $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'remunerasi_source' => 'required|exists:remunerasi_source,id',
            'nik' => 'required|string|max:50',
            'nama_pegawai' => 'required|string|max:255',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'dasar' => 'required|numeric|min:0|max:99999999.99',
            'kompetensi' => 'required|numeric|min:0|max:99999999.99',
            'resiko' => 'required|numeric|min:0|max:99999999.99',
            'emergensi' => 'required|numeric|min:0|max:99999999.99',
            'posisi' => 'required|numeric|min:0|max:99999999.99',
            'kinerja' => 'required|numeric|min:0|max:99999999.99',
            'nilai_indeks' => 'required|numeric|min:0|max:99999999.99',
            'pajak' => 'nullable|numeric|min:0|max:100',
            'rekening' => 'nullable|string|max:50'
        ]);

        // Check if record already exists (excluding current record)
        $existing = JtlPegawaiHasil::where('id_pegawai', $request->id_pegawai)
            ->where('remunerasi_source', $request->remunerasi_source)
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            return response()->json([
                'meta' => [
                    'status' => 'error',
                    'message' => 'Data pegawai untuk remunerasi source ini sudah ada!'
                ]
            ], 422);
        }

        // Calculate jumlah
        $jumlah = $request->dasar + $request->kompetensi + $request->resiko + 
                 $request->emergensi + $request->posisi + $request->kinerja;

        $data = $request->all();
        $data['jumlah'] = $jumlah;

        $jtlPegawaiHasil->update($data);

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Data JTL Pegawai Hasil berhasil diupdate!'
            ],
            'data' => $jtlPegawaiHasil
        ]);
    }

    public function destroy($id)
    {
        $jtlPegawaiHasil = JtlPegawaiHasil::findOrFail($id);
        $jtlPegawaiHasil->delete();

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Data JTL Pegawai Hasil berhasil dihapus!'
            ]
        ]);
    }

    public function export(Request $request)
    {
        $export = new JtlPegawaiHasilExport($request->all());
        return $export->download();
    }

    public function getByRemunerasiSource(Request $request, $remunerasiSourceId)
    {
        if ($request->ajax()) {
            $query = JtlPegawaiHasil::with(['pegawai', 'unitKerja', 'remunerasiSource'])
                ->where('remunerasi_source', $remunerasiSourceId)
                ->when($request->unit_kerja_id, function($q) use ($request) {
                    return $q->where('unit_kerja_id', $request->unit_kerja_id);
                })
                ->when($request->search, function($q) use ($request) {
                    return $q->where(function($query) use ($request) {
                        $query->where('nik', 'like', '%' . $request->search . '%')
                              ->orWhere('nama_pegawai', 'like', '%' . $request->search . '%');
                    });
                });

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('nama_pegawai', function($row) {
                    return $row->nama_pegawai;
                })
                ->addColumn('unit_kerja', function($row) {
                    return $row->unitKerja ? $row->unitKerja->nama : '-';
                })
                ->editColumn('dasar', function($row) {
                    return number_format($row->dasar, 2);
                })
                ->editColumn('kompetensi', function($row) {
                    return number_format($row->kompetensi, 2);
                })
                ->editColumn('resiko', function($row) {
                    return number_format($row->resiko, 2);
                })
                ->editColumn('emergensi', function($row) {
                    return number_format($row->emergensi, 2);
                })
                ->editColumn('posisi', function($row) {
                    return number_format($row->posisi, 2);
                })
                ->editColumn('kinerja', function($row) {
                    return number_format($row->kinerja, 2);
                })
                ->editColumn('jumlah', function($row) {
                    return '<span class="badge bg-primary">' . number_format($row->jumlah, 2) . '</span>';
                })
                ->editColumn('nilai_indeks', function($row) {
                    return number_format($row->nilai_indeks, 2);
                })
                ->editColumn('jtl_bruto', function($row) {
                    return '<span class="text-success fw-bold">Rp ' . number_format($row->jtl_bruto, 0, ',', '.') . '</span>';
                })
                ->editColumn('pajak', function($row) {
                    return $row->pajak ? number_format($row->pajak, 2) . '%' : '0%';
                })
                ->editColumn('potongan_pajak', function($row) {
                    return '<span class="text-warning">Rp ' . number_format($row->potongan_pajak, 0, ',', '.') . '</span>';
                })
                ->editColumn('jtl_net', function($row) {
                    return '<span class="text-info fw-bold">Rp ' . number_format($row->jtl_net, 0, ',', '.') . '</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-warning btn-edit" 
                                    data-url="' . route('jtl-pegawai-hasil.show', $row->id) . '">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" 
                                    data-url="' . route('jtl-pegawai-hasil.destroy', $row->id) . '">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['jumlah', 'jtl_bruto', 'potongan_pajak', 'jtl_net', 'action'])
                ->make(true);
        }

        $remunerasiSource = RemunerasiSource::findOrFail($remunerasiSourceId);
        $unitKerja = UnitKerja::orderBy('nama')->get();
        $pegawai = Pegawai::orderBy('nama')->get();

        return view('jtl-pegawai-hasil.by-remunerasi-source', compact('remunerasiSource', 'unitKerja', 'pegawai', 'remunerasiSourceId'));
    }
} 