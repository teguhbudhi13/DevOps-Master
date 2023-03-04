<?php

/*
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2022 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package   OpenSID
 * @author    Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2022 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

use App\Models\JamKerja;

defined('BASEPATH') || exit('No direct script access allowed');

class Kehadiran_jam_kerja extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->modul_ini          = 337;
        $this->sub_modul_ini      = 339;
        $this->header['kategori'] = 'kehadiran';
    }

    public function index()
    {
        return view('admin.jam_kerja.index');
    }

    public function datatables()
    {
        if ($this->input->is_ajax_request()) {
            return datatables()->of(JamKerja::query())
                ->addIndexColumn()
                ->addColumn('aksi', static function ($row) {
                    if (can('u')) {
                        return '<a href="' . route('kehadiran_jam_kerja.form', $row->id) . '" class="btn btn-warning btn-sm"  title="Ubah Data"><i class="fa fa-edit"></i></a> ';
                    }
                })
                ->editColumn('status', static function ($row) {
                    return ($row->status == 1) ? '<span class="label label-success">Hari Kerja</span>' : '<span class="label label-danger">Hari Libur</span>';
                })
                ->editColumn('jam_masuk', static function ($row) {
                    return date('H:i', strtotime($row->jam_masuk));
                })
                ->editColumn('jam_keluar', static function ($row) {
                    return date('H:i', strtotime($row->jam_keluar));
                })
                ->rawColumns(['aksi', 'status'])
                ->make();
        }

        return show_404();
    }

    public function form($id = '')
    {
        $this->redirect_hak_akses('u');

        $action      = 'Ubah';
        $form_action = route('kehadiran_jam_kerja.update', $id);
        // TODO: Gunakan findOrFail
        $kehadiran_jam_kerja = JamKerja::find($id) ?? show_404();

        return view('admin.jam_kerja.form', compact('action', 'form_action', 'kehadiran_jam_kerja'));
    }

    public function update($id = '')
    {
        $this->redirect_hak_akses('u');

        // TODO: Gunakan findOrFail
        $update = JamKerja::find($id) ?? show_404();

        if ($update->update($this->validate($this->request))) {
            redirect_with('success', 'Berhasil Ubah Data');
        }

        redirect_with('error', 'Gagal Ubah Data');
    }

    private function validate($request = [])
    {
        return [
            'jam_masuk'  => (string) date('H:i:s', strtotime($request['jam_masuk'])),
            'jam_keluar' => (string) date('H:i:s', strtotime($request['jam_keluar'])),
            'status'     => (int) ($request['status']),
            'keterangan' => strip_tags($request['keterangan']),
        ];
    }
}
